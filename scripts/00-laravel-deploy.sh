#!/usr/bin/env bash
echo "Running composer DELETE"
pwd
rm -rf vendor
rm -rf composer.lock
echo "DELETE composer pwd"
COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
composer global require hirak/prestissimo

composer update

composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
