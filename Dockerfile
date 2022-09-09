# Using the official PHP image.
FROM php:8.0-apache

# Setting up and installing required things for project

RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install -j "$(nproc)" pdo pdo_mysql
RUN apt-get install -y git zip unzip
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY composer.json composer.lock ./
RUN composer install
# RUN composer require kreait/firebase-php
RUN composer require vlucas/phpdotenv

# If in local, this will be overwritten to YES
ARG IS_THIS_LOCAL=NO

# Configure PHP for Cloud Run.
# Precompile PHP code with opcache.

# ------------------------!!! Only executing this if in cloud run!!!!!
RUN if [ "$IS_THIS_LOCAL" = "YES" ] ; then echo 'Doing nothing'; else docker-php-ext-install -j "$(nproc)" opcache; fi

# ------------------------!!! Only executing this if in cloud run!!!!!
RUN if [ "$IS_THIS_LOCAL" = "YES" ] ; then echo 'Doing nothing'; else set -ex; \
  { \
    echo "; Cloud Run enforces memory & timeouts"; \
    echo "memory_limit = -1"; \
    echo "max_execution_time = 0"; \
    echo "; File upload at Cloud Run network limit"; \
    echo "upload_max_filesize = 32M"; \
    echo "post_max_size = 32M"; \
    echo "; Configure Opcache for Containers"; \
    echo "opcache.enable = On"; \
    echo "opcache.validate_timestamps = Off"; \
    echo "; Configure Opcache Memory (Application-specific)"; \
    echo "opcache.memory_consumption = 32"; \
  } > "$PHP_INI_DIR/conf.d/cloud-run.ini" ; fi




# Copy in custom code from the Github repository root directory
WORKDIR /var/www/html
COPY . ./



# Use the PORT environment variable in Apache configuration files.
# https://cloud.google.com/run/docs/reference/container-contract#port

# ------------------------!!! Only executing this if in cloud run!!!!!
RUN if [ "$IS_THIS_LOCAL" = "YES" ] ; then echo 'Doing nothing'; else sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf; fi

# Configure PHP for development.
# Switch to the production php.ini for production operations.
# RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# https://github.com/docker-library/docs/blob/master/php/README.md#configuration

# ------------------------!!! Only executing this if in cloud run!!!!!
RUN if [ "$IS_THIS_LOCAL" = "YES" ] ; then echo 'Doing nothing'; else mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"; fi
