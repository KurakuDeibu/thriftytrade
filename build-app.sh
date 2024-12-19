#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x build-app.sh`

# Build assets using NPM
npm install --production
npm run production
composer install

# Clear cache
php artisan optimize:clear

# Cache the various components of the Laravel application
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
php artisan icons:cache
php artisan filament:cache-components
php artisan filament:assets

php artisan storage:link
