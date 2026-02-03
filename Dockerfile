FROM php:8.1-apache

# 1. Install dependencies (Added bcmath for money calculations)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 2. Enable Apache Rewrite (REQUIRED for PHPNuxBill links to work)
RUN a2enmod rewrite

# 3. Copy files
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Set Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
