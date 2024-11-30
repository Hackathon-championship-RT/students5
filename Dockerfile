FROM php:8.2-fpm

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpng-dev libjpeg-dev libfreetype6-dev libpq-dev \
    && docker-php-ext-install gd calendar intl opcache pdo zip pgsql pdo_pgsql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && pecl install apcu gd calendar pdo_pgsql pgsql \
    && docker-php-ext-enable apcu gd calendar pdo_pgsql pgsql

# Set the working directory
WORKDIR /var/www/project

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

