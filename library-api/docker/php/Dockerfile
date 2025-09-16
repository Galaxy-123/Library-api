FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/app

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]