#!/usr/bin/env bash

# You can also run as a cgi script with a max timeout and argument (problem #):
# php -d max_execution_time=240 index.php 47

/usr/local/bin/php -S 127.0.0.1:9988 server.php
