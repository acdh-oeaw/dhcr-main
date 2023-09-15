#!/bin/bash

### ENV ###
CAKE_PATH='/app'
export PATH="/app/.heroku/php/bin:${PATH}"

### CAKE COMMANDS ###
bin/cake gen_sitemap
