FROM php:8.3.3-fpm AS php

RUN apt update; apt install -y unzip 7zip git fswatch

ENV PHP_EXTENSIONS "redis xdebug pdo_mysql pdo_pgsql gd zip exif"

COPY deploy/local/php.ini-development "$PHP_INI_DIR/php.ini"
COPY deploy/local/99-xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions $PHP_EXTENSIONS

RUN groupadd -g 1000 default
RUN useradd -rm -d /home/default -s /bin/bash -g 1000 -u 1000 default

WORKDIR /var/www/html

USER 1000:1000

COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer

COPY . .
