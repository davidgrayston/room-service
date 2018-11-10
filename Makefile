update:
	docker run --rm -v "$(PWD):/app" composer update

install:
	docker run --rm -v "$(PWD):/app" composer install
	cp .env.roomservice .env

up:
	docker-compose up -d
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate

down:
	docker-compose down

test:
	docker-compose exec app php ./vendor/bin/phpunit
