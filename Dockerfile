FROM chialab/php:7.2-apache

ENV HTTPDUSER=www-data

RUN apt-get update && apt-get install -y vim curl nano links git 

COPY --chown=${HTTPDUSER}:${HTTPDUSER} . /var/www/html

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    php composer.phar update && \
    setfacl -R -m u:${HTTPDUSER}:rwx tmp && \
    setfacl -R -d -m u:${HTTPDUSER}:rwx tmp && \
    setfacl -R -m u:${HTTPDUSER}:rwx logs && \
    setfacl -R -d -m u:${HTTPDUSER}:rwx logs && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} /var/www/html
