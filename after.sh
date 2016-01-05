#!/bin/bash

# This file runs after the vagrant machine is provisioned via `vagrant up`
echo "Executing homestead extra provisioning ##################################"


echo "Installing ubuntu extras ################################################"
sudo apt-get install -y ack-grep;


echo "Run composer install and do database prep ###############################"
cd grandprix-run
composer install
php artisan migrate:install
php artisan migrate
php artisan db:seed


echo "Setting up XDebug RC WIP ################################################"
# Refs: http://www.dragonbe.com/2015/12/installing-php-7-with-xdebug-apache-and.html
#       http://blog.elenakolevska.com/debugging-laravel-on-homestead/
# FIXME: Make more DRY and maintainable with variables
XDEBUG_TGZ="xdebug-2.4.0rc3.tgz"
XDEBUG_MD5_CHECKSUM="cc799ad91b3addf9c92b15bdfc25e9ee"
sudo su;
cd /tmp/;
wget -nv http://xdebug.org/files/$XDEBUG_TGZ;
XDEBUG_MD5=`md5sum $XDEBUG_TGZ | awk '{print $1}'`

if [ $XDEBUG_MD5 == $XDEBUG_MD5_CHECKSUM ]; then
  echo "Checksum for XDebug tgz matches"
else
  echo "Checksum for XDebug tgz not matching. Panic!"
  exit 1
fi
# TODO: Get MD5 check working. One possible command is: `md5sum xdebug-2.4.0rc3.tgz`
#       md5check xdebug-2.4.0rc3.tgz cc799adi91b3addf9c92b15bdfc25e9ee;
tar -xvzf $XDEBUG_TGZ;
cd xdebug-2.4.0RC3/;
/usr/bin/phpize;
./configure --enable-xdebug --with-php-config=/usr/bin/php-config;
make;
# make test; # FIXME: Currently says: "ERROR: Cannot run tests without CLI sapi"
cp modules/xdebug.so /usr/lib/php/20151012;

# hhvm is running on port 9000 so we must run xdebug on 10000 instead
# this config assumes you use this chrome extension to start debugging and phpstorm
# https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc
echo "; configuration for php xdebug module
; priority=20
zend_extension=xdebug.so

xdebug.idekey = PHPSTORM
xdebug.profiler_enable = On
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 10000" > /etc/php/mods-available/xdebug.ini

ln -s /etc/php/mods-available/xdebug.ini /etc/php/7.0/cli/conf.d/20-xdebug.ini
ln -s /etc/php/mods-available/xdebug.ini /etc/php/7.0/fpm/conf.d/20-xdebug.ini
exit; # exit sudo

# Final Directions
echo "Add the following lines to your /etc/hosts file so you can access the"
echo "vagrant box laravel website from your localhost"
echo "192.168.10.10   grandprix-run"
echo "192.168.10.10   homestead.app"
