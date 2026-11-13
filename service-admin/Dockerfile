FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# Installation des dépendances système — avec curl-dev ajouté
RUN apk update && apk add --no-cache \
    git \
    unzip \
    curl \
    curl-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev

# Installation des extensions PHP — ctype retiré car intégré par défaut
RUN docker-php-ext-install \
    bcmath \
    curl \
    dom \
    fileinfo \
    mbstring \
    opcache \
    pdo_pgsql \
    xml \
    zip

# Activation de l'opcache
RUN docker-php-ext-enable opcache

# Copie de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html/public"]
