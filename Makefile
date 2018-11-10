update:
	docker run --rm -v "$(PWD):/app" composer update

install:
	docker run --rm -v "$(PWD):/app" composer install
	cp .env.example .env

up:
	docker-compose up -d
	docker-compose exec app php artisan key:generate

down:
	docker-compose down

test:
	docker-compose exec app php ./vendor/bin/phpunit
