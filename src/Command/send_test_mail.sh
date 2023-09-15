#!/bin/bash

### ENV ###
CAKE_PATH='/app'
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake send_test_mail
