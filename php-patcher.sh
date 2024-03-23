#!/bin/bash

TARGET_PHP_VERSION=$1

if [ -z "$TARGET_PHP_VERSION" ]; then
    echo "You must specify the target PHP version (e.g., 8.3)"
    exit 1
fi

PHP_INI_PATH="/etc/php/${TARGET_PHP_VERSION}/fpm/php.ini"
PHP_FPM_SERVICE="php${TARGET_PHP_VERSION}-fpm"

# Check if the specified PHP version is installed
if [ ! -f "$PHP_INI_PATH" ]; then
    echo "PHP INI for version ${TARGET_PHP_VERSION} not found."
    exit 1
fi

# Apply the necessary configurations for the project
sed -i 's/post_max_size = .*/post_max_size = 1G/' "$PHP_INI_PATH"
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 950M/' "$PHP_INI_PATH"
sed -i 's/memory_limit = .*/memory_limit = 256M/' "$PHP_INI_PATH"
sed -i 's/max_file_uploads = .*/max_file_uploads = 200/' "$PHP_INI_PATH"
sed -i 's/;opcache.enable=.*/opcache.enable=1/' "$PHP_INI_PATH"
sed -i 's/;opcache.enable_cli=.*/opcache.enable_cli=1/' "$PHP_INI_PATH"
sed -i 's/;opcache.memory_consumption=.*/opcache.memory_consumption=256/' "$PHP_INI_PATH"
sed -i 's/;opcache.preload=.*/opcache.preload=\/var\/www\/TheRetroWeb\/config\/preload.php/' "$PHP_INI_PATH"
sed -i 's/;opcache.preload_user=.*/opcache.preload_user=www-data/' "$PHP_INI_PATH"

echo "Configurations applied to PHP ${TARGET_PHP_VERSION}."

# Restart PHP FPM to apply changes
if systemctl is-active --quiet "$PHP_FPM_SERVICE"; then
    sudo systemctl restart "$PHP_FPM_SERVICE"
    echo "PHP FPM ${TARGET_PHP_VERSION} has been restarted."
else
    echo "PHP FPM service for version ${TARGET_PHP_VERSION} is not active or does not exist."
fi
