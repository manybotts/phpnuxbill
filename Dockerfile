FROM php:8.1-apache

# PHPNuxBill dependencies for Koyeb
# - pdo_mysql: main database connection
# - mysqli: settings/database status page uses mysqli
# - curl: HTTP callbacks, gateways, translations, notifications
# - gd/zip/mbstring/bcmath/etc: uploads, vouchers, money calculations, plugins
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Required for PHPNuxBill routed links
RUN a2enmod rewrite

COPY . /var/www/html
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

CMD ["apache2-foreground"]
