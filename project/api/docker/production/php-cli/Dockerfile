FROM php:7.4-fpm-alpine

RUN apk add unzip

# $PHP_INI_DIR = /usr/local/etc/php
# Внутри контейнера php:7.4-fpm-alpine лежат файлы php.ini-development и php.ini-production
# Считается хорошей практикой заменять php-ini на них, в зависимости от окружения
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/production/php-cli/conf.d $PHP_INI_DIR/conf.d

# Разрешаем composer исполнять компанды от root
ENV COMPOSER_ALLOW_SUPERUSER=1
# Скачиваем и устанавливаем composer в папку /bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY ./composer.json ./composer.lock ./

# --no-dev -> не устанавливает dev зависимости из composer.json
# --prefer-dist -> оптимизация
# --no-progress -> без строки прогресса
# --no-suggest -> без предложений
# --optimize-autoloader -> парсит все пакеты и создает оптимальный автозагрузчик
RUN composer install --no-dev --prefer-dist --no-progress --no-suggest --optimize-autoloader \
    && rm -rf /root/.composer/cache

COPY . .