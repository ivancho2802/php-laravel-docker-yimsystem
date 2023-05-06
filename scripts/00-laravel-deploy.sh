#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
rm -rf vendor
rm -rf composer.lock
composer install --no-dev --working-dir=/var/www/html
composer update

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
