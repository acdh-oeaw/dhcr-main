#!/bin/sh

### ENV ###

NOW=`date +\%Y-\%m-\%d_\%H:\%M:\%S`
CAKE_PATH='/var/www/html'

### CAKE COMMANDS ###

cd $CAKE_PATH && bin/cake discovery >> $CAKE_PATH/logs/$NOW-discovery.log 2>&1;

