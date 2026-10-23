# ==========================================
# Bước 1: Build assets (CSS/Vite) bằng Node.js
# ==========================================
FROM node:22-slim AS assets
WORKDIR /app

# Copy package.json trực tiếp trong thư mục backend
COPY package*.json ./
RUN npm ci --include=dev

COPY . .
RUN npm run build

# ==========================================
# Bước 2: Khởi chạy Laravel bằng PHP 8.3
# ==========================================
FROM php:8.3-cli
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Xóa view cache cũ và khởi chạy server
CMD sh -c "php artisan view:clear && php artisan config:clear && php artisan route:clear && php artisan storage:link --force || true; php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
