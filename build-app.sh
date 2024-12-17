#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x build-app.sh`

# Build assets using NPM
npm install
npm run build && npm run dev
composer install 
php artisan generate:key

# Clear cache
php artisan optimize:clear

# Cache the various components of the Laravel application
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
