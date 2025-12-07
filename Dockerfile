FROM php:8.2-alpine

# Install dependencies
RUN apk update --no-cache && \
    apk add --no-cache \
      curl \
      git \
      unzip \
      supervisor \
      bash \
      tzdata \
      libzip-dev \
      mysql-client \
      mysql-dev

# Set timezone
RUN cp /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && \
    echo "Asia/Jakarta" > /etc/timezone

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /workspace
COPY . .

# Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Scheduler script (runs forever every 60s)
RUN echo '#!/bin/sh' > /run-artisan.sh && \
    echo 'cd /workspace' >> /run-artisan.sh && \
    echo 'while true; do' >> /run-artisan.sh && \
    echo '  php artisan schedule:run' >> /run-artisan.sh && \
    echo '  sleep 60' >> /run-artisan.sh && \
    echo 'done' >> /run-artisan.sh && \
    chmod +x /run-artisan.sh

# Expose default port (Zeabur overrides this)
EXPOSE 8080

# Copy Supervisor config
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
