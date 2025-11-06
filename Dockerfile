FROM php:8.2-alpine

# Install dependencies WITHOUT mail capabilities
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    cronie \
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

# Setup cron job
RUN echo "* * * * * cd /workspace && php artisan schedule:run" > /etc/crontabs/root
RUN crontab /etc/crontabs/root

# Create a dummy sendmail to prevent errors
RUN ln -sf /bin/true /usr/sbin/sendmail

# Start cron and PHP server
CMD sh -c "crond -f & php artisan serve --host=0.0.0.0 --port=8080"