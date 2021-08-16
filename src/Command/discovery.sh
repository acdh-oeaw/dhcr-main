#!/bin/sh

### ENV ###

CAKE_PATH='/var/www/html'

### CAKE COMMANDS ###

cd $CAKE_PATH && bin/cake discovery 2>&1;

