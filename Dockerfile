FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  curl \
  libzip-dev \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  libpq-dev \
  && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY . .
# COPY public/.htaccess public/.htaccess
COPY public/.htaccess /var/www/html/public/.htaccess
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 775 storage bootstrap/cache

RUN a2enmod rewrite
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN php artisan key:generate

EXPOSE 80

CMD ["apache2-foreground"]



# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh

# ENTRYPOINT ["/entrypoint.sh"]
