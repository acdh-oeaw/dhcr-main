#!/bin/sh

### ENV ###
CAKE_PATH='/app'
export PATH="/layers/heroku_php/platform/bin:${PATH}"   # add PHP path

### CAKE COMMANDS ###
bin/cake send_test_mail
