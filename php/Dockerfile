FROM php:8.0.27-apache

RUN apt update && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-install intl opcache pdo pgsql pdo_pgsql mysqli pdo_mysql sockets \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN apt install -y git ftp wget vim

RUN apt install -y libssh2-1 libssh2-1-dev
# RUN wget https://pecl.php.net/get/ssh2-1.4.tgz -o ssh2.tgz \
RUN pecl install ssh2 \
    && docker-php-ext-enable ssh2
    # && rm -rf ssh2.tgz \
    # && rm -f ssh2-1.4.tgz

RUN apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

COPY mailpit_install.sh /mailpit_install.sh
RUN /mailpit_install.sh

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /home

COPY ./apache/sites-available/*.conf /etc/apache2/sites-available/

RUN a2ensite tva.docker.ueda.conf
RUN a2ensite itc.docker.ueda.conf
RUN a2ensite rkc.docker.ueda.conf
RUN a2ensite demo.docker.ueda.conf
# RUN a2ensite localhost.conf
RUN a2ensite uhb-front.docker.ueda.conf
RUN a2ensite nbs-front.docker.ueda.conf
# RUN a2ensite wp.docker.ueda.conf
RUN a2ensite test.docker.ueda.conf

# COPY startup.sh /startup.sh
# RUN chmod 744 /startup.sh
# CMD ["sh", "/startup.sh"]
