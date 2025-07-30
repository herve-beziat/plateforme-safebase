FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Permissions (optionnel)
RUN chown -R www-data:www-data /var/www/html

# Symfony uses index.php in /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ⚙️ Remplacer la configuration Apache par notre VirtualHost personnalisé
COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf
