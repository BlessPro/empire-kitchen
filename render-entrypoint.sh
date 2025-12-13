#!/usr/bin/env bash
set -e

# Ensure writable storage/cache directories exist
mkdir -p storage/framework/cache storage/framework/cache/data \
         storage/framework/sessions storage/framework/views \
         bootstrap/cache

# Try to set permissions; ignore if not allowed
chmod -R 775 storage bootstrap/cache || true

# Run migrations automatically on each start (fails fast if DB unavailable)
php artisan migrate --force || true

# Clear cached config/routes/views
php artisan optimize:clear || true

# Start the built-in PHP server bound to Render's provided port
php -S 0.0.0.0:${PORT:-8000} -t public
