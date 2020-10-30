FROM chialab/php:7.2-apache

RUN apt-get update && apt-get install -y vim curl nano links git 

COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    php composer.phar update 
