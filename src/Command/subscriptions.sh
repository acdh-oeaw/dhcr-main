#!/bin/sh

### ENV ###

CAKE_PATH='/app'
export PATH="/app/.heroku/php/bin:${PATH}"

### CAKE COMMANDS ###

bin/cake subscriptions 2>&1;

