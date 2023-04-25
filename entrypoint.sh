#!/bin/bash

export PATH="/app/.heroku/php/bin:${PATH}"

# Fetch data for Shibboleth login
bin/cake discovery

# Start web server
exec heroku-php-apache2 

