# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    unzip \
    zip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions required by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl

# 3. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 4. Set the Apache document root to Laravel's /public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Set working directory
WORKDIR /var/www/html

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Copy project files to the container
COPY . .

# 8. Install PHP dependencies
# --no-dev: Skip testing tools
# --optimize-autoloader: Speeds up class loading
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 9. Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Expose port 80
EXPOSE 80

# 11. Run Laravel optimization and start Apache
# Note: We don't run migrations here; we run them in Render's "Start Command" 
# to ensure the database is ready before the app starts.
CMD ["apache2-foreground"]