# Bước 1: Build CSS/JS bằng Node 22 trong thư mục /backend
FROM node:22-slim AS assets
WORKDIR /app/backend
COPY backend/package*.json ./
RUN npm ci --include=dev
COPY backend/ .
RUN npm run build

# Bước 2: Chạy Laravel bằng PHP
FROM php:8.3-cli
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app/backend
COPY backend/ .
COPY --from=assets /app/backend/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

CMD sh -c "php artisan storage:link --force || true; php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
