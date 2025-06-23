FROM node:24.2.0-alpine3.21 AS node

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

COPY . .

RUN npm run build

FROM php:8.4.8-fpm AS php

RUN apt update; apt install -y nginx git

ENV PHP_EXTENSIONS="redis pdo_mysql gd zip exif opcache"

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

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

COPY composer.json .
COPY composer.lock .

RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --no-progress

COPY . .

RUN composer dump-autoload -o
RUN php artisan route:cache

FROM php AS laravel

USER www-data

RUN php artisan view:cache

COPY --from=node /app/public/build /var/www/html/public/build

USER root

COPY deploy/remote/site.conf /etc/nginx/sites-enabled/default

COPY deploy/remote/laravel-docker-entrypoint.sh /etc/docker-entrypoint.sh

RUN chmod +x /etc/docker-entrypoint.sh

CMD ["/etc/docker-entrypoint.sh"]
