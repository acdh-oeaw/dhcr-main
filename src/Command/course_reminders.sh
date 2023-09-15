#!/bin/bash

### ENV ###
# Set PHP path
/app/src/Command/set_php_path.sh

### CAKE COMMANDS ###
bin/cake course_reminders 2>&1
