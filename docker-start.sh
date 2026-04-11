#!/bin/bash
set -e

echo "=== Starting YegnGebya ==="

PORT="${PORT:-80}"
echo "Configuring Apache on port $PORT"

sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# Write .env using PHP to avoid CRLF issues from Windows-created bash scripts
php -r "
\$lines = [
  'APP_NAME=' . getenv('APP_NAME') ?: 'YegnGebya',
  'APP_ENV=production',
  'APP_KEY=' . getenv('APP_KEY'),
  'APP_DEBUG=false',
  'APP_URL=' . (getenv('APP_URL') ?: 'http://localhost'),
  '',
  'LOG_CHANNEL=stack',
  'LOG_LEVEL=error',
  '',
  'DB_CONNECTION=mysql',
  'DB_HOST=' . getenv('DB_HOST'),
  'DB_PORT=' . (getenv('DB_PORT') ?: '3306'),
  'DB_DATABASE=' . getenv('DB_DATABASE'),
  'DB_USERNAME=' . getenv('DB_USERNAME'),
  'DB_PASSWORD=' . getenv('DB_PASSWORD'),
  '',
  'FILESYSTEM_DISK=public',
  'SESSION_DRIVER=file',
  'SESSION_LIFETIME=120',
  'CACHE_DRIVER=file',
  'QUEUE_CONNECTION=sync',
  '',
  'MAIL_MAILER=smtp',
  'MAIL_HOST=' . (getenv('MAIL_HOST') ?: 'smtp.gmail.com'),
  'MAIL_PORT=' . (getenv('MAIL_PORT') ?: '465'),
  'MAIL_USERNAME=' . getenv('MAIL_USERNAME'),
  'MAIL_PASSWORD=' . getenv('MAIL_PASSWORD'),
  'MAIL_ENCRYPTION=' . (getenv('MAIL_ENCRYPTION') ?: 'ssl'),
  'MAIL_FROM_ADDRESS=' . (getenv('MAIL_FROM_ADDRESS') ?: 'noreply@yegngebya.com'),
  'MAIL_FROM_NAME=' . (getenv('APP_NAME') ?: 'YegnGebya'),
  '',
  'CHAPA_SECRET_KEY=' . getenv('CHAPA_SECRET_KEY'),
  'CHAPA_PUBLIC_KEY=' . getenv('CHAPA_PUBLIC_KEY'),
  '',
  'GOOGLE_CLIENT_ID=' . getenv('GOOGLE_CLIENT_ID'),
  'GOOGLE_CLIENT_SECRET=' . getenv('GOOGLE_CLIENT_SECRET'),
  'GOOGLE_REDIRECT_URL=' . getenv('GOOGLE_REDIRECT_URL'),
  '',
  'GEMINI_API_KEY=' . getenv('GEMINI_API_KEY'),
];
file_put_contents('/var/www/html/.env', implode(\"\n\", \$lines) . \"\n\");
echo '.env created with LF line endings' . PHP_EOL;
"

echo "Waiting for database..."
for i in {1..30}; do
    php -r "new PDO('mysql:host='.getenv('DB_HOST').';port='.(getenv('DB_PORT')?:'3306').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" 2>/dev/null && break
    echo "DB not ready ($i/30)..."
    sleep 2
done

php artisan migrate --force 2>&1 || echo "Migration warning (continuing)..."
php artisan db:seed --class=RoleSeeder --force 2>/dev/null || true
php artisan config:cache
php artisan view:cache
php artisan storage:link 2>/dev/null || true
chmod -R 775 storage bootstrap/cache

# Fix MPM at runtime
rm -f /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_event.load \
      /etc/apache2/mods-enabled/mpm_worker.conf \
      /etc/apache2/mods-enabled/mpm_worker.load 2>/dev/null || true
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf 2>/dev/null || true
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load 2>/dev/null || true

echo "=== App ready on port $PORT ==="
exec apache2-foreground
