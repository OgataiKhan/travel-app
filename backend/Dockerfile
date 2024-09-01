# Use the official PHP image with Apache
FROM php:8.1-apache

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application files to the container
COPY . .

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Install any additional PHP extensions or dependencies if needed
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80 to the outside world
EXPOSE 80

# Set up necessary permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Start Apache server in the foreground
CMD ["apache2-foreground"]