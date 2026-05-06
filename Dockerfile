# Base image with PHP + Apache
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libldap2-dev \
    libzip-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*


# Install PHP extensions
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install \
        ldap \
        zip \
        pdo \
        pdo_mysql \
        mysqli


# Copy app
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80