#!/bin/sh
set -e

# Render fournit PORT (defaut 10000) ; en local on reste sur 80
PORT="${PORT:-80}"
sed "s/listen 80;/listen ${PORT};/" /etc/nginx/nginx.conf > /tmp/nginx-runtime.conf

php-fpm -D
exec nginx -c /tmp/nginx-runtime.conf -g 'daemon off;'