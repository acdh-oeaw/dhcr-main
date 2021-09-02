#!/bin/bash

cp dhcr-cron /etc/cron.d/ 
chmod 0644 /etc/cron.d/dhcr-cron
crontab /etc/cron.d/dhcr-cron 
cron -f &

bin/cake discovery

exec heroku-php-apache2 
