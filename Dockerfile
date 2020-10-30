FROM chialab/php:7.2-apache

COPY --chown=www-data:www-data . /var/www/html

RUN apt-get update && apt-get install -y vim curl nano links && php composer.phar update 

WORKDIR /var/www/html
