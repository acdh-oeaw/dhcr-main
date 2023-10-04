#!/bin/bash

### ENV ###
# Set PHP path
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake subscriptions 2>&1
