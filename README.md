# Ultimate Retro 

This repo contains all the necesary files to get the basic UR.net page up and running.
NOTE: This project is in the BETA stage. If something doesn't work right, it's expected behaviour :)

Now, onto getting UR.net running on a machine. So far, it's been tested and used in Debian (for both ARM and x86-64 platforms). It may work in other software/hardware configurations, but it's not guaranteed.

There are 6 requirements to get the project running:
1. A linux distro
2. PHP 8.0
3. Symfony (with CLI and Composer)
4. PostgreSQL
5. UFW
6. Git


Begin by making sure you have the latest updates with `sudo apt update`, then proceed to the next section.

# PHP install 

Here are the commands to install [PHP 7.4](https://computingforgeeks.com/how-to-install-latest-php-on-debian/) and it's required extensions for Symfony
```
sudo apt -y install lsb-release apt-transport-https ca-certificates 
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt update
sudo apt install php7.4 php7.4-mbstring php7.4-dom php7.4-gd php7.4-intl php7.4-pgsql php7.4-xsl
```
Install this as well, to let Composer run faster:`sudo apt install zip unzip php-zip`

# Symfony install
To install [CLI](https://symfony.com/download), run these:
```
wget https://get.symfony.com/cli/installer -O - | bash
sudo mv /home/user/.symfony/bin/symfony /usr/local/bin/symfony
```
And for [Composer](https://getcomposer.org/download/), run these:
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
php -r "unlink('composer-setup.php');"
```
# PostgreSQL install
Make sure you have a backup of the database ready for use by running this command on a server with UR.net already deployed on it, where [database name] is the name of the existing database, and [path/to/file.sql] is the path + filename where you want to save the backup (also make sure you save this file in a folder with enough permissions, otherwise it will complain): 
`pg_dump [database name] > [/path/to/file.sql]`

Now, back to the new machine, run these, where [username] is the username for the new database, [new database name] is the new database's name, and [password] is the password used in conjuction with the [username] for the new database:
```
sudo apt install postgresql postgresql-contrib
sudo -u postgres createuser [username]
sudo su postgres
psql
```

At this point, you are in psql, with a different prompt
```
CREATE DATABASE urdb2;
ALTER USER [username] WITH ENCRYPTED PASSWORD '[password]';
GRANT ALL PRIVILEGES ON DATABASE "[new database name]" to [username];
\q
psql [new database name]
\i [/path/to/file.sql]
\q
```

# UFW install
This is a firewall, recommended to use.
```
sudo apt install ufw
sudo ufw allow 8000
sudo ufw allow ssh
sudo ufw enable
```

# Git install
Finally, install git with these commands, where [name] and [email] are the ones from your git account, and [branch] is one of the branches from UR.net's git repo:
### Never modify origin/master, unless you know what you're doing!!!
```
sudo apt install git
git config --global user.name [name]
git config --global user.email [email]
cd /var/www
git clone https://gitlab.com/deksor/ultimateretro.git
cd ultimateretro
git checkout [branch]
```
## A few recommended steps:


Run these commands to have writing permissions to the local project files:
```
[make sure you're inside the /ultimateretro dir]
git config core.filemode false
cd ..
sudo chmod -R 777 ultimateretro
cd ultimateretro
```
A few directories will need write permissions in order for the site to run properly, such 
as /ultimateretro/var/ and /ultimateretro/public.

Run this command (inside /ultimateretro dir) if you want git to remember your credentials:
`git config --global credential.helper store`

Finally, add an environement file at the root (name: .env) with your own values for APP_ENV, APP_SECRET and DATABASEURL:
```
APP_ENV=[dev|prod]
APP_SECRET=[insert_here_the_value_you_want]
DATABASEURL=pgsql://[user]:[password]@[localhost]:[port]/[database]
```

Now, the project is ready to run, type `symfony serve -d --document-root=./` inside the /ultimateretro dir.
