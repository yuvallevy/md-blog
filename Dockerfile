# Start with the official PHP 8.3 image with Apache
FROM php:8.3-apache

# Enable necessary Apache modules
RUN a2enmod rewrite

# Allow .htaccess files to override routing rules
# (by default Apache does not allow .htaccess files to override settings)
RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf /etc/apache2/sites-available/*.conf

# Set the working directory
WORKDIR /var/www/html
