#!/bin/bash

### ENV ###
# Set PHP path
/app/src/Command/set_php_path.sh

### CAKE COMMANDS ###
bin/cake rem_course_name_spaces
