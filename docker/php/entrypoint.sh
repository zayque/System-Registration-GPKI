#!/bin/sh
set -e
cd /var/www/html
if [ ! -f vendor/autoload.php ]; then
  echo "[hadirin] Installing composer dependencies..."
  composer install --no-interaction --prefer-dist --no-progress
fi
exec docker-php-entrypoint "$@"
