#!/bin/sh

### ENV ###

CAKE_PATH='/app'
export PATH="/app/.heroku/php/bin:${PATH}"

### CAKE COMMANDS ###

app/bin/cake subscriptions 2>&1;
