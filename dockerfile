# base image PHP 8.2 with extensions
FROM php:8.2-fpm

# install deps
RUN apt-get update && apt-get install -y \
    zip unzip git libzip-dev libpng-dev libonig-dev libxml2-dev \
    libcurl4-openssl-dev libpq-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate

EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
