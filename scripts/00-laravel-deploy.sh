#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer update
composer install --no-dev --working-dir=/var/www/html
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
