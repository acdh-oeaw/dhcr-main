FROM chialab/php:7.2-apache

ENV HTTPDUSER=www-data \
    API_BASE_URL=https://dev-dhcr.clarin-dariah.eu/api/v1/ \
    DHCR_BASE_URL=https://dev-dhcr.clarin-dariah.eu/ \
    OPS_BASE_URL=https://dev-dhcr.clarin-dariah.eu/ops/ \
    APP_MAIL_DEFAULT_CC=dh-course-registry@oeaw.ac.at \
    APP_MAIL_DEFAULT_FROM=dh-course-registry@dhcr.clarin-dariah.eu \
    DEBUG=true \
    MAIL_SMTP_HOST=smtp.oeaw.ac.at \
    MAIL_SMTP_PORT=25 \
    MAIL_TRANSPORT_CLASS=Cake\Mailer\Transport\SmtpTransport \
    DB_HOST=helios.arz.oeaw.ac.at \
    DB_PORT=3306 \
    DB_USER=dhregistry \
    DB_NAME=dev-dhregistry
    
RUN apt-get update && apt-get install -y vim curl nano links git 

COPY --chown=${HTTPDUSER}:${HTTPDUSER} . /var/www/html

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    mkdir tmp logs && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} /var/www/html && \
    php composer.phar update && \
    cd /var/www/html/api/v1 && php composer.phar update && \
    cp /var/www/html/composer.phar /var/www/html/ops/app && cd /var/www/html/ops/app && php composer.phar update && \
    cd /var/www/html && \
    chown -R ${HTTPDUSER}:${HTTPDUSER} /var/www/html
