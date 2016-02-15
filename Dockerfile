FROM php:7.0-fpm

COPY config/php.ini /usr/local/etc/php/conf.d/custom.ini
ADD ./src/ /var/www/html/
