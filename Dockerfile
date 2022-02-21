FROM php:8.0-apache

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

ENV APACHE_DOCUMENT_ROOT /var/www/htdocs
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql 

COPY ./htdocs /var/www/htdocs
COPY ./lib /var/www/lib
COPY ./templates /var/www/templates
COPY ./vendor /var/www/vendor
# Set hostname todo: error
RUN sed -i '/#!/bin/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint
