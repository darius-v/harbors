.PHONY: start stop init tests

start:
	docker-compose up -d

stop:
	docker-compose stop

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

tests:
	docker-compose exec php vendor/bin/phpunit
