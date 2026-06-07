FROM php:8.2-apache

# Copia los archivos al servidor
COPY . /var/www/html/

# Le da permisos a Apache para que pueda leer y mostrar la web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
