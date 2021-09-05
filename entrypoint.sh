#!/bin/bash

su herokuishuser
export PATH="/app/.heroku/php/bin:${PATH}"

cp /app/composer.phar /app/ops/app/
cp /app/composer.phar /app/api/v1/
cd /app/ops/app/ && php composer.phar update
cd /app/api/v1/ && php composer.phar update
cd /app/

bin/cake discovery
bin/cake plugin load DebugKit

# Start web server
exec heroku-php-apache2 
