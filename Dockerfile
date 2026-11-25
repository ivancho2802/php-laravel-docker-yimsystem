FROM serversideup/php:8.4-fpm-nginx

# Cambiar a root para instalar extensiones adicionales si las necesitas (ej. pgsql, gd, intl)
USER root
RUN install-php-extensions intl bcmath gd

# Copiar los archivos del proyecto
COPY --chown=www-data:www-data . /var/www/html

# Volver al usuario seguro por defecto
USER www-data

# Instalar dependencias de producción de Composer
RUN composer install --no-dev --optimize-autoloader

# Variables de entorno para Laravel en Render
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PHP_OPCACHE_ENABLE=1
ENV NGINX_WEBROOT=/var/www/html/public
ENV SSL_MODE=off

EXPOSE 8080
