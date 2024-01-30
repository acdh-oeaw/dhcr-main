#!/bin/bash

# Enable PHP intl and set path
source /app/src/Command/includes.sh
prepare_php

# Generate JSON file required for searchbar
bin/cake gen_search_list
