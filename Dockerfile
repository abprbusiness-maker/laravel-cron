FROM php:8.2-alpine

# Update dan install dependencies
RUN apk update --no-cache && \
    apk add --no-cache \
      curl \
      git \
      unzip \
      supervisor \
      mysql-client \
      mysql-dev \
      bash \
      libzip-dev \
      tzdata

# Set timezone
RUN cp /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && \
    echo "Asia/Jakarta" > /etc/timezone

# Install PHP extensions untuk MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /workspace
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Setup supervisord
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Dummy sendmail
RUN ln -sf /bin/true /usr/sbin/sendmail

# Jalankan supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]