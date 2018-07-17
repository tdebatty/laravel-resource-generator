#!/bin/bash

cd /tmp
git clone git@github.com:tdebatty/laravel-resource-generator-test.git
cd laravel-resource-generator-test/laravel-5.6
composer install
cp .env.example .env
touch storage/app/db.sqlite
php artisan migrate

php artisan resource-generator:generate Product
php artisan migrate
./vendor/bin/phpunit
RESULT=$?


echo "Cleanup..."
rm storage/app/db.sqlite
rm app/Product.php
rm app/Http/Controllers/ProductController.php
rm database/migrations/*_create_products_table.php
rm -Rf resources/views/product/

sed -i "/Route::resource('app\/products', 'ProductController');/d" routes/web.php

exit $RESULT
