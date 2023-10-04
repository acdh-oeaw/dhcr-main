#!/bin/sh

### ENV ###
CAKE_PATH='/app'
# Set PHP path
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
cd $CAKE_PATH && bin/cake discovery 2>&1;
