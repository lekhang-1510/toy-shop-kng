FROM php:8.2-apache

# 1. Cài đặt các extension PHP và Node.js (để build CSS/JS)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql zip

# 2. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Đưa mã nguồn vào container
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Cài đặt package PHP và BUILD FRONTEND ASSETS (quan trọng cho Blade + Vite)
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 5. Phân quyền thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6. Cấu hình Apache trỏ vào thư mục public của Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80