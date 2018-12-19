install:
	docker run --rm -v "$(PWD):/app" composer install
	cp .env.roomservice .env
	docker-compose up -d
	docker-compose exec -T app php artisan key:generate
	sleep 10
	docker-compose exec -T app php artisan migrate

up:
	docker-compose up -d

down:
	docker-compose down

update:
	docker run --rm -v "$(PWD):/app" composer update

test:
	docker-compose exec -T app php ./vendor/bin/phpunit
