#!/bin/bash
set -e

echo "Building Node assets..."
npm install
npm run build

echo "Installing PHP dependencies..."
composer install --optimize-autoloader --no-scripts --no-interaction

echo "Running Laravel package discovery..."
php artisan package:discover --ansi

echo "Running Filament upgrade..."
php artisan filament:upgrade

echo "Build complete!"
