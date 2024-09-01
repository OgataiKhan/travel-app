# Use the official PHP image from Docker Hub
FROM php:8.1-apache

# Copy application files to the container
COPY . /var/www/html/

# Set up necessary permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Install any additional PHP extensions or dependencies here (optional)
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
