#!/bin/bash

# Enable PHP intl and set path
source /app/src/Command/includes.sh
prepare_php

# Send course reminders
bin/cake review_reminders