FROM php:8.2-apache

# Cài đặt các extension cần thiết cho Laravel và Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ mã nguồn vào container
COPY . /var/www/html
WORKDIR /var/www/html

# Cài đặt các package PHP thông qua Composer (không cài gói dev)
RUN composer install --no-dev --optimize-autoloader

# Cấp quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Trỏ Apache document root thẳng vào thư mục public của Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80