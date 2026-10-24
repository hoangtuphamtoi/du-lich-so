FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory inside container
WORKDIR /var/www/html

# Copy everything into container
COPY . .

# Move into backend and install dependencies
WORKDIR /var/www/html/backend
RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

# Trỏ thẳng tuyệt đối tới file artisan trong thư mục hiện tại của backend
CMD ["php", "/var/www/html/backend/artisan", "serve", "--host=0.0.0.0", "--port=10000"]
