# Utilisation de l'image officielle PHP 8.4 avec FPM
FROM php:8.4-fpm-alpine

# Informations sur le mainteneur
LABEL maintainer="SGPE Team"
LABEL description="Microservice SGPE â€” PHP 8.4 / Laravel 12"

# Mise Ã  jour des paquets et installation des dÃ©pendances systÃ¨me
RUN apk update && apk add --no-cache \
    nginx \
    curl \
    postgresql-dev \
    curl-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    bash \
    git \
    unzip

# Installation des extensions PHP
RUN docker-php-ext-install pdo \
    pdo_pgsql \
    curl \
    zip \
    gd \
    mbstring \
    bcmath \
    opcache

# Configuration de PHP
RUN cp /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# DÃ©finition du rÃ©pertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de l'application
COPY . .

# Serveur web nginx + PHP-FPM
COPY nginx.conf /etc/nginx/nginx.conf
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Installation des dÃ©pendances Composer (si vendor est absent)
RUN if [ ! -d "vendor" ]; then \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
        composer install --no-dev --optimize-autoloader --no-scripts; \
    fi

# Permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# VÃ©rification de la santÃ© du conteneur
HEALTHCHECK --interval=30s --timeout=5s --start-period=15s --retries=3 \
    CMD curl -f "http://localhost:${PORT:-80}/up" || exit 1

# Ports exposÃ©s : HTTP (nginx) et FPM
EXPOSE 80 9000

# DÃ©marrage : PHP-FPM + nginx
CMD ["sh", "/usr/local/bin/start.sh"]
