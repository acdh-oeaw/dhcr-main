#!/bin/bash

mkdir -p /app/.heroku/php/etc/php/conf.d
cp /layers/heroku_php/platform/etc/php/php.ini /app/.heroku/php/etc/php/
sed -i 's|;user_ini.filename|user_ini.filename|g' /app/.heroku/php/etc/php/php.ini
cp .user.ini /app/.heroku/php/etc/php/conf.d/

chown -R 1000:1000 /app/.heroku

# Set PHP path
/app/src/Command/set_php_path.sh

# Generate JSON file required for searchbar
bin/cake gen_search_list

# Generate XML sitemap
bin/cake gen_sitemap

# Fetch data for Shibboleth login
bin/cake discovery

# Start web server
exec heroku-php-apache2
