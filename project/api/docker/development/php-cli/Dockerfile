FROM php:7.4-fpm-alpine

# Установка пакета unzip, который нужен для composer
RUN apk update && apk add unzip

# $PHP_INI_DIR = /usr/local/etc/php
# Внутри контейнера php:7.4-fpm-alpine лежат файлы php.ini-development и php.ini-production
# Считается хорошей практикой заменять php-ini на них, в зависимости от окружения
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# Разрешаем composer исполнять компанды от root
ENV COMPOSER_ALLOW_SUPERUSER=1
# Скачиваем и устанавливаем composer в папку /bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add Composer to the PATH
ENV PATH="$PATH:/usr/local/bin"

COPY ./conf.d $PHP_INI_DIR/conf.d

WORKDIR /app