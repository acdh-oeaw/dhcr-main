#!/bin/bash

# Enable PHP intl and set path
source /app/src/Command/includes.sh
prepare_php

### CAKE COMMANDS ###
bin/cake send_test_mail
