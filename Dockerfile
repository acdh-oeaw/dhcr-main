FROM php:7.2-apache

COPY --chown=1000:1000 . /var/www/html

RUN apt-get update && apt-get install -y software-properties-common 
RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -y \
        php7.2 php7.2-common php7.2-gd php7.2-mysql php7.2-imap \
        php7.2-cli  \
        php-pear php7.2-mcrypt php7.2-curl php7.2-intl php7.2-pspell php7.2-recode php7.2-sqlite3 php7.2-tidy \
        php7.2-xmlrpc php7.2-xsl php7.2-zip php7.2-mbstring php7.2-soap && \
    apt-get clean    

RUN php composer.phar update 

WORKDIR /var/www/html
