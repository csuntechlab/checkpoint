FROM php:7.3-rc-apache

# Install php extensions
RUN docker-php-ext-install pdo_mysql \
# Enable apache modules
  && a2enmod headers rewrite \
# Add user local dev env groups to www-data group
  && usermod -u 1000 www-data && usermod -G staff www-data 

# Expose port 80 and 443
EXPOSE 80 443