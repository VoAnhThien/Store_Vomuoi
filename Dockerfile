FROM php:8.2-fpm

# Cài đặt dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring gd zip \
    && apt-get clean

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo user
RUN useradd -G www-data,root -u 1000 -d /home/www www \
    && mkdir -p /home/www/.composer \
    && chown -R www:www /home/www

# Thiết lập working directory
WORKDIR /var/www

USER www
