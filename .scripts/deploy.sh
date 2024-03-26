#!/bin/bash
set -e

echo "Deployment started!"

# Enter maintenance mode
(php artisan down) || true

#
git pull origin production

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreat cache
php artisan optimize

# install npm packages
#npm install

# Compile npm assets
#npm run build

# Migrate the database
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
