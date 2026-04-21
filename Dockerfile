FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash curl zip unzip git \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev oniguruma-dev nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN chown -R www-data:www-data storage bootstrap/cache
RUN mkdir -p /run/nginx

EXPOSE 8080

CMD sh -c "php artisan config:cache && php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'"