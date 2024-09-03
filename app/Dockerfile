FROM php:8.0.27-fpm-alpine

WORKDIR /home

ENV TZ=Asia/Tokyo \
    LANG=ja_JP.UTF-8 \
    LC_ALL=ja_JP.UTF-8

RUN apk update \
    && apk add --no-cache \
    bash \
    curl \
    lftp \
    git \
    vim \
    zlib-dev \
    libpng-dev \
    libpq-dev \
    libjpeg-turbo-dev \
    libssh2-dev \
    libzip-dev \
    build-base \
    freetype-dev \
    autoconf

RUN pecl install ssh2-1.4.1

RUN docker-php-ext-configure \
    gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    gd \
    mysqli \
    pdo_mysql \
    pgsql \
    pdo_pgsql \
    sockets \
    zip

RUN docker-php-ext-enable \
    ssh2

COPY ./mailpit_install.sh /mailpit_install.sh
RUN /mailpit_install.sh
