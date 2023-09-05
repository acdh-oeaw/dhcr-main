#!/bin/bash

sed -i 's|;extension=intl|extension=intl|g' /layers/heroku_php/platform/etc/php/php.ini

export PATH="/layers/heroku_php/platform/bin:${PATH}"

# Generate JSON file required for searchbar
bin/cake gen_search_list

# Generate XML sitemap
bin/cake gen_sitemap

# Fetch data for Shibboleth login
bin/cake discovery

# Start web server
exec heroku-php-apache2 

