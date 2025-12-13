#!/usr/bin/env bash
set -e

# Ensure writable storage/cache directories exist
mkdir -p storage/framework/cache storage/framework/cache/data \
         storage/framework/sessions storage/framework/views \
         bootstrap/cache

# Try to set permissions; ignore if not allowed
chmod -R 775 storage bootstrap/cache || true

# Clear cached config/routes/views
php artisan optimize:clear || true

# Uncomment if you want migrations to run automatically on each start
# php artisan migrate --force || true

# Start the built-in PHP server bound to Render's provided port
php -S 0.0.0.0:${PORT:-8000} -t public
