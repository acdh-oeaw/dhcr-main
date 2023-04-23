#!/bin/sh

### ENV ###

CAKE_PATH='/app'
export PATH="/app/.heroku/php/bin:${PATH}"

### CAKE COMMANDS ###

cd $CAKE_PATH && bin/cake gen_search_list 2>&1
