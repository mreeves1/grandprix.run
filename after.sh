#!/bin/sh

# This runs after the vagrant machine is provisioned via `vagrant up`

echo "Executing homestead extra provisioning"
echo "Run composer install and do database prep"
cd grandprix-run
composer install
php artisan migrate:install
php artisan migrate
php artisan db:seed

echo "Add the following lines to your /etc/hosts file so you can access the"
echo "vagrant box laravel website from your localhost"
echo "192.168.10.10   grandprix-run"
echo "192.168.10.10   homestead.app"
