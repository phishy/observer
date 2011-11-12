#!/bin/bash

/var/www/automata.me/observer/cake/console/cake -app /var/www/automata.me/observer/app monitor | tee -a /var/www/automata.me/observer/app/webroot/observer.log
