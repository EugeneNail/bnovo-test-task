env:
	cp .env.example .env

build:
	docker-compose build

up:
	docker-compose up -d

migrate:
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed CountrySeeder

all: env build up migrate seed
