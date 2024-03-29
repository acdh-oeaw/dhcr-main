#!/bin/bash

# Enable PHP intl and set path
source /app/src/Command/includes.sh
prepare_php

# Generate JSON file required for searchbar
bin/cake gen_search_list

# Generate XML sitemap
bin/cake gen_sitemap

## Fetch data for Shibboleth login
#bin/cake discovery

# Start web server
exec heroku-php-apache2
