#!/bin/bash
set -e

echo "=== Polimicro Railway Startup ==="

# Ensure storage directories exist and are writable
echo ">>> Creating storage directories..."
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/logs
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Cache config, routes, views
echo ">>> Caching configuration..."
php artisan config:cache || echo "[WARN] config:cache failed, continuing..."

echo ">>> Caching routes..."
php artisan route:cache || echo "[WARN] route:cache failed, continuing..."

echo ">>> Caching views..."
php artisan view:cache || echo "[WARN] view:cache failed, continuing..."

# Run migrations
echo ">>> Running migrations..."
php artisan migrate --force || echo "[WARN] migrate failed, continuing..."

# Create storage symlink
echo ">>> Creating storage link..."
php artisan storage:link || echo "[WARN] storage:link failed, continuing..."

echo "=== Starting PHP server on port $PORT ==="
exec php -S 0.0.0.0:$PORT -t public
