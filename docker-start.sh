#!/bin/bash
set -e

echo "=== Starting የኛ ገበያ ==="

# Only generate key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Wait for DB to be ready
echo "Waiting for database..."
sleep 3

# Run migrations
php artisan migrate --force

# Seed roles if needed
php artisan db:seed --class=RoleSeeder --force 2>/dev/null || true

# Cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link 2>/dev/null || true

# Fix permissions
chmod -R 775 storage bootstrap/cache

echo "=== App ready! Starting Apache ==="
apache2-foreground
