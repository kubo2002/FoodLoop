FROM php:8.3-fpm

# systémové balíčky
RUN apt-get update && apt-get install -y \
    unzip zip git libzip-dev libpng-dev \
    && docker-php-ext-install pdo_mysql zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
