#!/bin/bash

# Enable PHP intl and set path
source /app/src/Command/includes.sh
prepare_php

# Generate XML sitemap
bin/cake gen_sitemap
