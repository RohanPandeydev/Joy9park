# Joy9 Park — WordPress on Render (Docker web service)
FROM php:8.3-apache

# PHP extensions WordPress needs / recommends
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg62-turbo-dev libwebp-dev libfreetype6-dev \
        libzip-dev libicu-dev libonig-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install -j"$(nproc)" gd mysqli pdo_mysql zip intl mbstring exif opcache bcmath \
    && a2enmod rewrite headers expires remoteip \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php.ini      /usr/local/etc/php/conf.d/wordpress.ini
COPY docker/apache.conf  /etc/apache2/conf-available/wordpress.conf
RUN a2enconf wordpress

# Application code (wp-config.php is generated from env vars, see docker/wp-config.php)
COPY --chown=www-data:www-data . /var/www/html
RUN cp /var/www/html/docker/wp-config.php /var/www/html/wp-config.php \
 && cp /var/www/html/docker/htaccess      /var/www/html/.htaccess \
 && mkdir -p /var/www/html/wp-content/uploads \
 && chown -R www-data:www-data /var/www/html/wp-content/uploads /var/www/html/.htaccess /var/www/html/wp-config.php

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENV PORT=10000
EXPOSE 10000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
