# Gunakan PHP 8.2 FPM
FROM php:8.2-fpm

# Set Working Directory
WORKDIR /var/www/html

# Update & Install Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql zip intl gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel Application
COPY . .

# Install Dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Optimize Laravel
RUN php artisan key:generate \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan config:cache \
    && php artisan route:cache

# Buat folder storage publik
RUN mkdir -p /var/www/html/storage \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Jalankan storage link jika belum ada
RUN php artisan storage:link || true

# Railway menggunakan PORT environment variable
ENV PORT=8080
EXPOSE 8080

# Jalankan server Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
