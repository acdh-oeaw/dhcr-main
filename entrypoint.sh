#!/bin/bash

su herokuishuser
cp /app/composer.phar /app/ops/app/
cp /app/composer.phar /app/api/v1/
cd /app/ops/app/ && /app/.heroku/php/bin/php composer.phar update
cd /app/api/v1/ && /app/.heroku/php/bin/php composer.phar update
cd /app/

# Start web server
exec heroku-php-apache2 
