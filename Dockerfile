# ---------- Frontend Build ----------
FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build

# ---------- Laravel App ----------
FROM php:8.3-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    sqlite3 \
    libsqlite3-dev

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy built Vite assets
COPY --from=frontend /app/public/build ./public/build

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=$PORT