#!/usr/bin/env bash

docker-compose down --remove-orphans
docker-compose up -d
sleep 10
docker-compose exec -T php bash -c "composer install"
docker-compose exec -T php bash -c "yarn install"
cp .env.example .env
docker-compose exec -T php bash -c "vendor/bin/doctrine migrations:migrate -n"