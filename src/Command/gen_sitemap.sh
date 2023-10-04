#!/bin/sh

### ENV ###
# Set PHP path
export PATH="/layers/heroku_php/platform/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake gen_sitemap
