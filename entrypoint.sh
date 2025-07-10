#!/bin/bash

echo "Esperando a la base de datos..."
until php artisan migrate --force > /dev/null 2>&1; do
  >&2 echo "La base de datos aún no está lista... esperando..."
  sleep 3
done

echo "✔️ Base de datos disponible. Continuando con la configuración..."

php artisan migrate --force
php artisan db:seed --force

php artisan passport:install --force
php artisan passport:client --personal --no-interaction

if [ ! -f /var/www/html/storage/oauth-private.key ]; then
  php artisan key:generate
fi

php artisan storage:link

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

exec apache2-foreground
