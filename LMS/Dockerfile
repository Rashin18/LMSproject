# Use official PHP image with FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Laravel setup (safe caching with fallback)
RUN if [ -f artisan ]; then \
        php artisan config:clear || echo " cache failed"; \
    fi
RUN if [ -f artisan ]; then \
        php artisan cache:clear || echo " cache failed"; \
    fi
RUN if [ -f artisan ]; then \
        php artisan route:clear && \
        php artisan route:cache || echo "route cache failed"; \
    fi

RUN if [ -f artisan ]; then \
        php artisan view:clear && \
        php artisan view:cache || echo "view cache failed"; \
    fi
RUN if [ -f artisan ]; then \
        php artisan config:cache || echo "config cache failed"; \
    fi
RUN if [ -f artisan ]; then \
        php artisan migrate || echo "migrate failed"; \
    fi


# DO NOT run migrations during build; it's a runtime task (do it in console after deploy)

# Expose port for Laravel
EXPOSE 8000

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


