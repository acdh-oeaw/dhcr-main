FROM chialab/php:7.2-apache

ENV HTTPDUSER=www-data \
    WEBROOT=/var/www/html 

RUN apt-get update && apt-get install -y vim curl nano links git cron 

COPY --chown=${HTTPDUSER}:${HTTPDUSER} . ${WEBROOT}

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    mkdir tmp logs && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} ${WEBROOT} && \
    php composer.phar update && \
    cp ${WEBROOT}/composer.phar ${WEBROOT}/api/v1 && cd ${WEBROOT}/api/v1 && php composer.phar update && \
    cp ${WEBROOT}/composer.phar ${WEBROOT}/ops/app && cd ${WEBROOT}/ops/app && php composer.phar update && \
    cd ${WEBROOT} && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} ${WEBROOT} && \
    cp dhcr-cron /etc/cron.d/ && \
    chmod 0644 /etc/cron.d/dhcr-cron && \
    crontab /etc/cron.d/dhcr-cron 

