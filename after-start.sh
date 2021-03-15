#!/bin/bash

echo 'change dir to /var/www/html/'
cd /var/www/html/
echo 'changing files and directories permissions within the storage directory'
chmod 775 ./storage
find ./storage -type f -exec chmod 664 {} \;
find ./storage -type d -exec chmod 775 {} \;
echo 'changing files and directories permissions within the vendor directory'
chmod 775 ./vendor
find ./vendor -type f -exec chmod 664 {} \;
find ./vendor -type d -exec chmod 775 {} \;
echo 'Cleaning configuration cache'
php artisan config:clear
echo 'Running composer install and dump-autoload'
composer install
composer dump-autoload
echo 'Running database migration'
php artisan migrate
echo 'Updating places in the database'
php artisan bikes:update
echo 'Running npm install and npm run prod'
npm install
npm run prod
echo 'Done.'
