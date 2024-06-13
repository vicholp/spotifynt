FROM nginxinc/nginx-unprivileged:1.26 AS nginx

ENV BACKEND_PHP=backend-php

COPY ./deploy/remote/site.conf /etc/nginx/conf.d/default.conf

COPY . /var/www/html

RUN sed -i "s/backend-php/$BACKEND_PHP/g" /etc/nginx/conf.d/default.conf
