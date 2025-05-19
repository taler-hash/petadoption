cd app

cd public

rmdir storage

cd ../

php artisan storage:link

git pull

composer install

php artisan migrate:refresh --seed

npm install