#!/bin/sh
set -e

# Serveur HTTP PHP integre (simple, suffisant pour la demo)
exec php artisan serve --host=0.0.0.0 --port="${PORT:-80}"