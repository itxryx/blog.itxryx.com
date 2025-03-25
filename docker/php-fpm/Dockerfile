FROM php:8.4.5-fpm-bookworm

RUN set -eux \
    && apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y vim git make libzip-dev default-mysql-client \
    && docker-php-ext-install opcache bcmath pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 9000

CMD ["php-fpm"]
