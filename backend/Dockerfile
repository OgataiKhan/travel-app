# Use the official PHP image with Apache
FROM php:8.1-apache

# Install Composer
RUN apt-get update && apt-get install -y \
    curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files to the container
COPY . /var/www/html/

# Set up necessary permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Install PHP dependencies using Composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Install any additional PHP extensions or dependencies if needed
# Example: Install MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
