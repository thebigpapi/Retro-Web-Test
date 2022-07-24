# The Retro Web

This repo contains all the necesary files to get the basic TRW page up and running.
NOTE: This project is in the BETA stage. If something doesn't work right, it's expected behaviour :)

Now, onto getting TRW running on a machine. So far, it's been tested and used in Debian, Ubuntu and a Docker environment (for both ARM and x86-64 platforms). It may work in other software/hardware configurations, but it's not guaranteed.

There are 7 requirements to get the project running:
1. A linux distro
2. PHP 8.0
3. Symfony (with CLI and Composer)
4. PostgreSQL
5. UFW
6. Git
7. npm + yarn
8. (optional) Docker


Begin by making sure you have the latest updates with `sudo apt update`, then proceed to the next section.

# PHP install 

Here are the commands to install [PHP 8.0](https://computingforgeeks.com/how-to-install-latest-php-on-debian/) and it's required extensions for Symfony
```
sudo apt -y install lsb-release apt-transport-https ca-certificates 
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt update
sudo apt install php8.0 php8.0-mbstring php8.0-dom php8.0-gd php8.0-intl php8.0-pgsql php8.0-xsl
```
Install this as well, to let Composer run faster:`sudo apt install zip unzip php-zip`

# Symfony install
To install [CLI](https://symfony.com/download), run these:
```
wget https://get.symfony.com/cli/installer -O - | bash
sudo mv /home/user/.symfony/bin/symfony /usr/local/bin/symfony
```
And for [Composer](https://getcomposer.org/download/), run the commands provided on their site.

# PostgreSQL install
Make sure you have a backup of the database ready for use by running this command on a server with TRW already deployed on it, where [database name] is the name of the existing database, and [path/to/file.sql] is the path + filename where you want to save the backup (also make sure you save this file in a folder with enough permissions, otherwise it will complain): 
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
CREATE DATABASE [new database name];
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
Install git with these commands, where [name] and [email] are the ones from your git account, and [branch] is one of the branches from TRW's git repo:
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

## npm/yarn install:
Run these commands to install npm, and then use npm to install yarn, which will be used to compile all the stuff in the /assets folder (CSS, images, etc.)
```
sudo apt install npm
npm install --global yarn
```
You can then type `yarn` in the project root to install all the dependencies, after which you can run `yarn dev encore --watch` to start compiling the /assets folder.

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

Finally, add an environement file at the root (name: .env) with your own values for APP_ENV, APP_SECRET and DATABASEURL:
```
APP_ENV=[dev|prod]
APP_SECRET=[insert_here_the_value_you_want]
DATABASEURL=pgsql://[user]:[password]@[localhost]:[port]/[database]
```

Now, the project is ready to run, type `symfony serve -d --document-root=./` inside the /ultimateretro dir, or configure it to run with your favorite flavour of web server (apache, nginx, etc..).
