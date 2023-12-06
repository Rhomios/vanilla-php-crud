FROM php:8.2-apache

COPY . .


RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

EXPOSE 80

RUN echo "Listen 80" > /etc/apache2/ports.conf

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

RUN service apache2 restart

CMD ["apache2-foreground"]


