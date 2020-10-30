FROM chialab/php:7.2-apache

ENV HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`

RUN apt-get update && apt-get install -y vim curl nano links git 

COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

RUN git submodule sync --recursive && \
    git submodule update --init --recursive && \
    php composer.phar update && \
    setfacl -R -m u:${HTTPDUSER}:rwx tmp && \
    setfacl -R -d -m u:${HTTPDUSER}:rwx tmp && \
    setfacl -R -m u:${HTTPDUSER}:rwx logs && \
    setfacl -R -d -m u:${HTTPDUSER}:rwx logs && \
    chown -R www-data:www-data /var/www/html
