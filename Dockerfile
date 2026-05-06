# Base image with PHP + Apache
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libldap2-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mods (optional but common)
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap zip

# Install MQTT client via PECL
RUN pecl install mosquitto \
    && docker-php-ext-enable mosquitto

# Copy app
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80