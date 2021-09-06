#!/bin/bash

export PATH="/app/.heroku/php/bin:${PATH}"

bin/cake discovery

# Start web server
exec heroku-php-apache2 

