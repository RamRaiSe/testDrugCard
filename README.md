# testDrugCard

docker compose up -d

docker compose exec app composer install

docker compose exec app php bin/console d:m:m

docker compose exec app php bin/console messenger:consume async -vv

docker compose exec app php bin/console app:parse-products

docker compose exec app ./vendor/bin/phpunit
