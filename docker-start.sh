#!/bin/bash
set -e

echo "=== Starting የኛ ገበያ ==="

# Railway injects PORT env var - configure Apache to use it
PORT="${PORT:-80}"
echo "Configuring Apache on port $PORT"

# Update Apache port config
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# Create .env from Railway environment variables
cat > /var/www/html/.env << ENVEOF
APP_NAME="${APP_NAME:-YegnGebya}"
APP_ENV=production
APP_KEY="${APP_KEY}"
APP_DEBUG=false
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST="${DB_HOST}"
DB_PORT="${DB_PORT:-3306}"
DB_DATABASE="${DB_DATABASE}"
DB_USERNAME="${DB_USERNAME}"
DB_PASSWORD="${DB_PASSWORD}"

FILESYSTEM_DISK=public
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST="${MAIL_HOST:-smtp.gmail.com}"
MAIL_PORT="${MAIL_PORT:-465}"
MAIL_USERNAME="${MAIL_USERNAME}"
MAIL_PASSWORD="${MAIL_PASSWORD}"
MAIL_ENCRYPTION="${MAIL_ENCRYPTION:-ssl}"
MAIL_FROM_ADDRESS="${MAIL_FROM_ADDRESS:-noreply@yegngebya.com}"
MAIL_FROM_NAME="${APP_NAME:-YegnGebya}"

CHAPA_SECRET_KEY="${CHAPA_SECRET_KEY}"
CHAPA_PUBLIC_KEY="${CHAPA_PUBLIC_KEY}"

GOOGLE_CLIENT_ID="${GOOGLE_CLIENT_ID}"
GOOGLE_CLIENT_SECRET="${GOOGLE_CLIENT_SECRET}"
GOOGLE_REDIRECT_URL="${GOOGLE_REDIRECT_URL}"

GEMINI_API_KEY="${GEMINI_API_KEY}"
ENVEOF

echo ".env created"

# Wait for DB to be ready
echo "Waiting for database..."
for i in {1..30}; do
    php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT:-3306};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null && break
    echo "DB not ready yet ($i/30)..."
    sleep 2
done

# Run migrations
php artisan migrate --force 2>&1 || echo "Migration warning (continuing)..."

# Seed roles
php artisan db:seed --class=RoleSeeder --force 2>/dev/null || true

# Cache
php artisan config:cache
php artisan view:cache

# Storage link (idempotent - remove if exists, then create)
rm -f /var/www/html/public/storage
php artisan storage:link

chmod -R 775 storage bootstrap/cache

echo "=== App ready on port $PORT ==="
exec apache2-foreground
