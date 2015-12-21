#!/bin/sh

# This runs after the vagrant machine is provisioned via `vagrant up`

echo "Executing homestead extra provisioning"
echo "Run composer install and do database prep"
cd grandprix-run
composer install
php artisan migrate:install
php artisan migrate
php artisan db:seed
