.PHONY: start stop init build tests

#include .env
#export $(shell sed 's/=.*//' .env)

start:
	docker-compose up -d

stop:
	docker-compose stop

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

build:
	build/build.sh

tests:
	docker-compose exec php vendor/bin/phpunit
