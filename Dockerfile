# Use official PHP image with Apache
FROM php:8.2-apache

# Install required system dependencies and PHP extensions for Laravel
# - git, unzip, curl: useful for dependencies and debugging
# - libpq-dev: required for PostgreSQL driver (pdo_pgsql)
# - libpng-dev, libonig-dev, libxml2-dev, zip: common Laravel requirements
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Enable Apache mod_rewrite (required for Laravel pretty URLs)
RUN a2enmod rewrite

# Install Composer (copied from the official Composer image)
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www/html

# Copy project files into the container
COPY . .

# Install PHP dependencies in production mode (no dev packages)
RUN composer install --no-dev --optimize-autoloader

# Fix permissions for Laravel storage and bootstrap/cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy custom Apache configuration for Laravel
COPY ./docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 (default HTTP)
EXPOSE 80

# Run Apache in the foreground (container entrypoint)
CMD ["apache2-foreground"]
