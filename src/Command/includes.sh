#!/bin/bash

function prepare_php() {
    # set path
    export PATH="/layers/heroku_php/platform/bin:${PATH}"
    # enable intl module
    mkdir -p /app/.heroku/php/etc/php/conf.d
    cp /layers/heroku_php/platform/etc/php/php.ini /app/.heroku/php/etc/php/
    sed -i 's|;user_ini.filename|user_ini.filename|g' /app/.heroku/php/etc/php/php.ini
    cp .user.ini /app/.heroku/php/etc/php/conf.d/
    chown -R 1000:1000 /app/.heroku
}
