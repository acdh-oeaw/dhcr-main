#!/bin/sh

### ENV ###
# Set PHP path
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake send_test_mail
