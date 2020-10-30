FROM chialab/php:7.2-apache

COPY --chown=1000:1000 . /var/www/html

RUN php composer.phar update 

WORKDIR /var/www/html
