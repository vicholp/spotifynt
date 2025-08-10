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
RUN php artisan view:cache

FROM php AS nginx

USER root

COPY deploy/remote/site.conf /etc/nginx/sites-enabled/default

COPY deploy/remote/php-entrypoint.sh /etc/entrypoint.sh

RUN chmod +x /etc/php-entrypoint.sh

CMD ["/etc/php-entrypoint.sh"]
