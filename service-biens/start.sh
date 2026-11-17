#!/bin/sh
set -e

# php artisan serve (php -S) ne propage pas les variables d'environnement
# au processus web : on materialise un .env a partir de l'environnement.
ENV_FILE=/var/www/html/.env

{
  echo "APP_NAME=\"SGPE\""
  echo "APP_ENV=${APP_ENV:-production}"
  echo "APP_KEY=${APP_KEY}"
  echo "APP_DEBUG=${APP_DEBUG:-false}"
  echo "APP_URL=${APP_URL:-http://localhost}"
  echo ""
  echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}"
  echo "DB_HOST=${DB_HOST}"
  echo "DB_PORT=${DB_PORT:-5432}"
  echo "DB_DATABASE=${DB_DATABASE}"
  echo "DB_USERNAME=${DB_USERNAME}"
  echo "DB_PASSWORD=\"${DB_PASSWORD}\""
  echo "DB_SCHEMA=${DB_SCHEMA:-public}"
  echo "DB_SSLMODE=${DB_SSLMODE:-require}"
  echo ""
  echo "CACHE_STORE=${CACHE_STORE:-file}"
  echo "SESSION_DRIVER=${SESSION_DRIVER:-file}"
  echo "QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}"
  echo ""
  echo "APP_URL_BIENS=${APP_URL_BIENS:-}"
  echo "APP_URL_GESTION=${APP_URL_GESTION:-}"
  echo "APP_URL_ADMIN=${APP_URL_ADMIN:-}"
  echo "CORS_ALLOWED_ORIGINS=${CORS_ALLOWED_ORIGINS:-*}"
  echo ""
  echo "ADMIN_EMAIL=${ADMIN_EMAIL:-}"
  echo "ADMIN_PASSWORD=\"${ADMIN_PASSWORD:-}\""
} > "$ENV_FILE"

exec php artisan serve --host=0.0.0.0 --port="${PORT:-80}"
