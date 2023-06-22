#!/bin/bash

export PATH="/app/.heroku/php/bin:${PATH}"

# Generate JSON file required for searchbar
bin/cake gen_search_list

# Generate XML sitemap
bin/cake gen_sitemap

# Fetch data for Shibboleth login
bin/cake discovery

# Start web server
exec heroku-php-apache2 

