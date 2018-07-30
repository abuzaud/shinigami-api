FROM php:7.2-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /var/www/shinigami/htdocs
RUN chown -R www-data:www-data /var/www