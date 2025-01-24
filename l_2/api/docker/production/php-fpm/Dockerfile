FROM php:7.4-fpm-alpine

# $PHP_INI_DIR = /usr/local/etc/php
# Внутри контейнера php:7.4-fpm-alpine лежат файлы php.ini-development и php.ini-production
# Считается хорошей практикой заменять php-ini на них, в зависимости от окружения
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/production/php-fpm/conf.d $PHP_INI_DIR/conf.d