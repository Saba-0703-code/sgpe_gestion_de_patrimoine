FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

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

RUN docker-php-ext-enable opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/var/www/html/public"]
