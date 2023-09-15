#!/bin/bash

### ENV ###
CAKE_PATH='/app'
# Set PHP path
/app/src/Command/set_php_path.sh

### CAKE COMMANDS ###
cd $CAKE_PATH && bin/cake discovery 2>&1;
