#!/usr/bin/env bash
echo "Running composer"
pwd
rm -rf vendor
rm -rf composer.lock
echo "DELETE composer pwd"
composer global require hirak/prestissimo

composer install --no-dev --working-dir=/var/www/html
composer update

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
