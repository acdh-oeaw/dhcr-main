#!/bin/bash

su herokuishuser
export PATH="/app/.heroku/php/bin:${PATH}"

bin/cake discovery
bin/cake plugin load DebugKit

# Start web server
exec heroku-php-apache2 
