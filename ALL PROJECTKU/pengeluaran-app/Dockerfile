FROM php:8.1-apache
WORKDIR /var/www/html

RUN docker-php-ext-install mysqli

COPY app/ /var/www/html/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
