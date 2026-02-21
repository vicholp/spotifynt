FROM php:8.4.8-fpm AS php

RUN apt update; apt install -y unzip 7zip git fswatch

ENV PHP_EXTENSIONS="redis xdebug pdo_mysql gd zip exif"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions $PHP_EXTENSIONS

COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer


# 2. Create the 'vscode' user (UID 1000 is standard for the first user)
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN apt-get update && apt-get install -y sudo \
    && groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME \
    # Create the directory just in case, then the file
    && mkdir -p /etc/sudoers.d \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

# 5. [Optional] Set the default user for the container
USER $USERNAME
