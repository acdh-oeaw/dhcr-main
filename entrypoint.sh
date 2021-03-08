#!/bin/bash

cron -f &
docker-php-entrypoint apache2-foreground
