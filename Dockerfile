FROM php:8.2-alpine

# Install dependencies
RUN apk add --no-cache curl git unzip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /workspace
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]