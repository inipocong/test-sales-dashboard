FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libonig-dev \
    libxml2-dev curl && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath xml zip

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_MEMORY_LIMIT=-1

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize && php artisan package:discover --ansi || true
RUN php artisan storage:link || true

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080} -t public"]

RUN php artisan migrate --force
RUN php artisan db:seed --force
