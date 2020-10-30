FROM chialab/php:7.2-apache

ENV HTTPDUSER=www-data

RUN apt-get update && apt-get install -y vim curl nano links git 

COPY --chown=${HTTPDUSER}:${HTTPDUSER} . /var/www/html

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    mkdir tmp logs && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} /var/www/html && \
    php composer.phar update && \
    cd /var/www/html/api && php composer.phar update && \
    cd /var/www/html/ops && php composer.phar update && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} /var/www/html
