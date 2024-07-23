FROM php:8.1

RUN apt-get update && apt-get install -y \
	git \
	zip \
	curl \
	sudo \
	unzip \
	libzip-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install \
	mysqli \
	pdo \
	pdo_mysql \
	zip

WORKDIR /var/www/html

COPY . ./

RUN composer install

EXPOSE 8000
