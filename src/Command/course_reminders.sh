#!/bin/sh

### ENV ###
# Set PHP path
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake course_reminders 2>&1
