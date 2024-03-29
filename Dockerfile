FROM php:8.0-apache
ARG includeXdebug
# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# Set error logging to stderr
# RUN sed -i "s/;error_log = syslog/error_log = \/dev\/stderr/g" "$PHP_INI_DIR/php.ini"

# Install and configure Xdebug
RUN if [ "$includeXdebug" = "true" ]  ; then pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "zend_extension=xdebug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=VSCODE" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "zend_extension=xdebug.so" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=no" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    ; else echo Without Xdebug ; fi

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
# RUN sed -i '/#!/bin/sh/echo "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint


