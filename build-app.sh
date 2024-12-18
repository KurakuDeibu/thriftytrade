#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x build-app.sh`

# Build assets using NPM
npm install
composer install
npm install laravel-echo pusher-js

# Clear cache
php artisan optimize:clear


# Cache the various components of the Laravel application
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan filament:optimize
php artisan filament:optimize-clear
php artisan view:cache
php artisan optimize

php artisan storage:link
