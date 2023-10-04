#!/bin/sh

### ENV ###
# Set PHP path
source /app/src/Command/set_php_path.sh

### CAKE COMMANDS ###
bin/cake subscriptions 2>&1
