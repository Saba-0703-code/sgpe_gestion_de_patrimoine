# Utilisation de l'image officielle PHP 8.4 avec FPM
FROM php:8.4-fpm-alpine

# Informations sur le mainteneur
LABEL maintainer="SGPE Team"
LABEL description="Microservice SGPE — PHP 8.4 / Laravel 12"

# Mise à jour des paquets et installation des dépendances système
RUN apk update && apk add --no-cache \
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

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de l'application
COPY . .

# Installation des dépendances Composer (si vendor est absent)
RUN if [ ! -d "vendor" ]; then \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
        composer install --no-dev --optimize-autoloader --no-scripts; \
    fi

# Permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Vérification de la santé du conteneur
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD curl -f http://localhost/ping || exit 1

# Exposition du port FPM
EXPOSE 9000

# Démarrage de PHP-FPM (commande par défaut de l'image, ne pas la surcharger)
CMD ["php-fpm"]
