install:
	docker run --rm -v "$(PWD):/app" composer install
	cp .env.roomservice .env
	docker-compose up -d
	docker-compose exec app php artisan key:generate
	sleep 5
	docker-compose exec app php artisan migrate

up:
	docker-compose up -d

down:
	docker-compose down

update:
	docker run --rm -v "$(PWD):/app" composer update

test:
	docker-compose exec app php ./vendor/bin/phpunit
