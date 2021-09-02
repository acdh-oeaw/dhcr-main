#!/bin/bash

# Run cake discovery before starting web server
bin/cake discovery
# Start web server
exec heroku-php-apache2 
