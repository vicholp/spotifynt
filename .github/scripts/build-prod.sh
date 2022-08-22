#! /bin/bash

composer install --no-dev --no-ansi --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader
npm i --only=prod

php artisan storage:link --relative

npm run prod

./bin/prod-php artisan config:cache
./bin/prod-php artisan route:cache
./bin/prod-php artisan view:cache
