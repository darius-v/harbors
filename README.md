# Harbors

### Project setup

* Run `make init` to initialize project

* Open in browser: http://localhost:8000 .

### Run tests

`make tests`

### How to enable xdebug

* Uncoment line in docker/php/Dockerfile
`RUN pecl install xdebug && docker-php-ext-enable xdebug opcache`
* Uncomment line in docker-compose.yml 
`- ./docker/php/conf.d/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini`
* run `make init`

### Various commands

Get into container:

`docker exec -it harbors_php bash`
