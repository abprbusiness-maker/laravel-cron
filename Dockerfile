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

# Set timezone secara eksplisit
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

# Buat script untuk menjalankan artisan dengan environment yang benar
RUN echo '#!/bin/sh' > /run-artisan.sh && \
    echo 'cd /workspace' >> /run-artisan.sh && \
    echo 'export APP_ENV=local' >> /run-artisan.sh && \
    echo 'export APP_DEBUG=true' >> /run-artisan.sh && \
    echo 'export APP_URL=https://laravel-cron.zeabur.app/' >> /run-artisan.sh && \
    echo 'export DISCORD_WEBHOOK_URL=https://discord.com/api/webhooks/1436033524237996203/teYNvHOFjQeiZR6OK9rXqutNXksnuVTvEHCOrOGJ5hj5we4XAuzBze0tAFek0y0RTYWs' >> /run-artisan.sh && \
    echo 'export DISCORD_WEBHOOK_URL_WEATHER=https://discord.com/api/webhooks/1436582125770899507/I_6BpsbtNCep2camiwrabT2UjTUbaEVkjPqu0tpKlODN0ZgFTQBe_ohiZoQQ37lJ8EMi' >> /run-artisan.sh && \
    echo 'export APP_TIMEZONE=Asia/Jakarta' >> /run-artisan.sh && \
    echo 'while true; do' >> /run-artisan.sh && \
    echo '  php artisan schedule:run' >> /run-artisan.sh && \
    echo '  sleep 60' >> /run-artisan.sh && \
    echo 'done' >> /run-artisan.sh && \
    chmod +x /run-artisan.sh




# Dummy sendmail
RUN ln -sf /bin/true /usr/sbin/sendmail

# Jalankan supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]