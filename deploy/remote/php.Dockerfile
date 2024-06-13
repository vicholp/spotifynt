## PHP

FROM php:8.3.3-fpm AS php

ENV PHP_EXTENSIONS="redis pdo_mysql pdo_pgsql gd zip exif"

COPY deploy/remote/php.ini-production "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions $PHP_EXTENSIONS

WORKDIR /var/www/html

USER www-data

RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/logs

COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

COPY composer.json .
COPY composer.lock .

RUN composer install --no-dev --no-scripts --no-autoloader \
    --no-interaction --no-progress

COPY . .

RUN composer dump-autoload -o
RUN php artisan route:cache

