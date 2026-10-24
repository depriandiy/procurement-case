#!/bin/sh

set -eu

key_file=/var/www/html/storage/app/.app-key
wait_seconds=60

mkdir -p \
    /var/www/html/storage/app \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

if [ -z "${APP_KEY:-}" ]; then
    if [ ! -s "$key_file" ]; then
        umask 077
        php -r 'echo "base64:", base64_encode(random_bytes(32)), PHP_EOL;' > "$key_file"
    fi

    APP_KEY=$(cat "$key_file")
    export APP_KEY
fi

echo "Waiting for MySQL..."
attempt=0
until php -r '
    try {
        new PDO(
            sprintf("mysql:host=%s;port=%s;dbname=%s", getenv("DB_HOST"), getenv("DB_PORT"), getenv("DB_DATABASE")),
            getenv("DB_USERNAME"),
            getenv("DB_PASSWORD"),
            [PDO::ATTR_TIMEOUT => 2],
        );
    } catch (Throwable $exception) {
        exit(1);
    }
'; do
    attempt=$((attempt + 1))

    if [ "$attempt" -ge "$wait_seconds" ]; then
        echo "MySQL was not ready after ${wait_seconds} seconds." >&2
        exit 1
    fi

    sleep 1
done

php artisan migrate --force
php artisan optimize:clear
php artisan db:seed --force

exec "$@"
