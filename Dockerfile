FROM richarvey/nginx-php-fpm:latest

# Copy source code
COPY . /var/www/html

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Laravel storage link
RUN php artisan storage:link || true

# Optimize
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan cache:clear
RUN php artisan view:clear

