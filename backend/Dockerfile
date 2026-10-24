```dockerfile
# ==========================================
# Stage 1: Build frontend
# ==========================================
FROM node:22-slim AS assets

WORKDIR /frontend

COPY frontend/package*.json ./
RUN npm install

COPY frontend/ ./
RUN npm run build


# ==========================================
# Stage 2: Run Laravel backend
# ==========================================
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
       pdo \
       pdo_mysql \
       pdo_sqlite \
       mbstring \
       zip \
       gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY backend/ ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

COPY --from=assets /frontend/dist ./public/build

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    database \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
```
