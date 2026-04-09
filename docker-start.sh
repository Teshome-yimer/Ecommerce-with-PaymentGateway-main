#!/bin/bash
set -e

echo "=== Starting የኛ ገበያ ==="

# Create .env from environment variables (Railway doesn't have .env file)
cat > /var/www/html/.env << EOF
APP_NAME="${APP_NAME:-YegnGebya}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
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
MAIL_FROM_ADDRESS="${MAIL_FROM_ADDRESS}"
MAIL_FROM_NAME="${APP_NAME:-YegnGebya}"

CHAPA_SECRET_KEY="${CHAPA_SECRET_KEY}"
CHAPA_PUBLIC_KEY="${CHAPA_PUBLIC_KEY}"

GOOGLE_CLIENT_ID="${GOOGLE_CLIENT_ID}"
GOOGLE_CLIENT_SECRET="${GOOGLE_CLIENT_SECRET}"
GOOGLE_REDIRECT_URL="${GOOGLE_REDIRECT_URL}"

GEMINI_API_KEY="${GEMINI_API_KEY}"
EOF

echo ".env created successfully"

# Wait for DB
echo "Waiting for database..."
sleep 5

# Run migrations - continue even if some fail
php artisan migrate --force 2>&1 || echo "Some migrations had issues, continuing..."

# Seed roles
php artisan db:seed --class=RoleSeeder --force 2>/dev/null || true

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link 2>/dev/null || true

chmod -R 775 storage bootstrap/cache

echo "=== App ready! ==="
apache2-foreground
