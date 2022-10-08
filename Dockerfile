FROM php:8.0.19-fpm-alpine

RUN apk add --no-cache \
    wget \
    bash \
    php8-tokenizer \
    php8-dom \
    php8-xml \
    php8-xmlwriter \
    php8-simplexml \
    php8-sockets \
    php8-fileinfo \
    composer

RUN mkdir /app
COPY ./ /app/
WORKDIR /app/

RUN composer update

EXPOSE [9000, 8000]
ENTRYPOINT ["php-fpm"]
