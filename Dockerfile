FROM php:8.2-alpine3.23

# Update dan install dependencies
RUN apk update --no-cache && \
    apk add --no-cache \
      curl \
      git \
      unzip \
      cronie \
      mysql-client \
      mysql-dev \
      bash \
      libzip-dev \
      tzdata

# Install PHP extensions untuk MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /workspace
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Setup cron job (kalau lo mau tetap pake cron di image)
RUN echo "* * * * * cd /workspace && php artisan schedule:run >> /dev/null 2>&1" > /etc/crontabs/root
RUN crontab /etc/crontabs/root

# Dummy sendmail supaya nggak error di mail functions
RUN ln -sf /bin/true /usr/sbin/sendmail

# Jalankan cron & laravel server
CMD sh -c "crond -f & php artisan serve --host=0.0.0.0 --port=8080"
