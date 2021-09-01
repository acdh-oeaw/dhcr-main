#!/bin/bash

cron -f &
/var/www/html/bin/cake discovery
docker-php-entrypoint apache2-foreground
