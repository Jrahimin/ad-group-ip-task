# Use the official PHP 8.1 FPM image as the base
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    vim \
    # Install dependencies for Redis extension
    autoconf \
    gcc \
    make \
    # Clean up
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory in the container to /var/www
WORKDIR /var/www

# Copy the application's code to the container
COPY . /var/www

# Set correct permissions for the Laravel application
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Use the non-root user 'www-data' provided by the base image
USER www-data

# The command that runs when the container starts
CMD ["php-fpm"]
