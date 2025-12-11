FROM php:8.2-apache-bullseye

ENV TIMEZONE=Europe/Budapest

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip intl

RUN a2enmod rewrite

COPY php.ini "$PHP_INI_DIR/php.ini"
COPY apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www

ENTRYPOINT ["/entrypoint.sh"]
