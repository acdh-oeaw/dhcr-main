#!/bin/sh

### ENV ###

CAKE_PATH='/app'

### CAKE COMMANDS ###

cd $CAKE_PATH && bin/cake subscriptions 2>&1;

