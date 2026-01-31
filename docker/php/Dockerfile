FROM php:8.4-fpm-alpine

# System deps
RUN apk add --no-cache \
    git \
    unzip \
    libpq-dev \
    bash \
    shadow \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
