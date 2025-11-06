FROM php:8.2-alpine

# Install dependencies + cron + MySQL extensions
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    cronie \
    supervisor \
    mysql-client \
    mysql-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /workspace
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup permissions
RUN chmod -R 775 storage bootstrap/cache

# Setup cron job - FIX: remove the -l option
RUN echo "* * * * * cd /workspace && /usr/local/bin/php artisan schedule:run >> /dev/stdout 2>&1" > /etc/crontabs/root
RUN chmod 0644 /etc/crontabs/root

# FIX: Remove the -l option from crond
CMD sh -c "crond -f & php artisan serve --host=0.0.0.0 --port=8080"