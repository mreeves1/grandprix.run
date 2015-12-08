#!/usr/bin/env bash

PORT="8899"

# first you must install hhvm
# `brew tap hhvm/hhvm`
# `brew install hhvm`
# to get the config files to work you must create
# /usr/local/var/log/hhvm and /usr/local/var/run/hhvm

# You can also run as a cgi script with a max timeout and argument (problem #):
# /usr/local/bin/hhvm -d max_execution_time=240 index.php 47

# Or run it this way?
# /usr/local/bin/hhvm --mode debug --port 8888 index.php 1
# /usr/local/bin/hhvm --mode server --port 8888 index.php
# /usr/local/bin/hhvm --mode server -c /usr/local/etc/hhvm/php.ini -c /usr/local/etc/hhvm/server.ini index.php
echo "Starting HHVM Server on port ${PORT}"
/usr/local/bin/hhvm --mode server --port ${PORT} -c /usr/local/etc/hhvm/php.ini server.php

# Only issue is the destructor does not send the output to the web browser. It does work with CGI though.
# -vEval.EnableObjDestructCall=1 does not seem to help
