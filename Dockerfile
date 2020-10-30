ARG PHP_EXTENSIONS="apcu mysqli pdo_mysql soap"
FROM thecodingmachine/php:7.3-v3-slim-apache as php_base
ENV PHP_EXTENSIONS="apcu mysqli pdo_mysql soap" \
    PHP_EXTENSION_MYSQLI=1 \
    PHP_EXTENSION_PDO_MYSQL=1 \
    PHP_EXTENSION_GD=1 \
    PHP_EXTENSION_IMAGICK=1 \
    APACHE_DOCUMENT_ROOT=/ \
    APACHE_RUN_USER=docker \
    APACHE_RUN_GROUP=docker
COPY --chown=docker:docker . /var/www/html

RUN php composer.phar update 

WORKDIR /var/www/html
