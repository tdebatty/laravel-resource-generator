#!/bin/bash

cd /tmp
git clone git@github.com:tdebatty/laravel-resource-generator-test.git
cd laravel-resource-generator-test/laravel-5.6
composer install
composer require tdebatty/laravel-resource-generator:dev-master
cp .env.example .env
touch storage/app/db.sqlite
php artisan migrate
php artisan key:generate

php artisan resource-generator:generate Product
php artisan migrate
./vendor/bin/phpunit

