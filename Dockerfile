FROM webdevops/php-nginx:7.4 as builder
LABEL MAINTAINER="yimsystem"

RUN usermod -a www-data -G application
RUN usermod -a www-data -G root
RUN usermod -a application -G root

WORKDIR /var/www

#Copying files
COPY ./k8/.env.cert ./.env
COPY ./ ./

RUN echo memory_limit = 3000 M >> /opt/docker/etc/php/php.ini

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update
RUN apt-get install -y libpq-dev


# Install PHP extensions
RUN docker-php-ext-install opcache pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd
RUN docker-php-ext-enable redis

ENV PHP_FPM_PM="dynamic"
ENV PHP_FPM_MAX_CHILDREN="5"
ENV PHP_FPM_START_SERVERS="2"
ENV PHP_FPM_MIN_SPARE_SERVERS="1"
ENV PHP_FPM_MAX_SPARE_SERVERS="2"
ENV PHP_FPM_MAX_REQUESTS="1000"
ENV WEB_DOCUMENT_ROOT=/var/www/public
ENV HTTPS=on


RUN chown -Rf application:www-data /var/www
RUN chmod -Rf 775 /var/www/storage/

#RUN chmod -R ugo+rw /var/www/storage/

ENV PHP_OPCACHE_ENABLE="1"
ENV PHP_OPCACHE_MEMORY_CONSUMPTION="128"
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES="10000"
ENV PHP_OPCACHE_REVALIDATE_FREQUENCY="0"
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0"

RUN docker-php-ext-install opcache

#Configs
ADD ./k8/opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"
COPY ./k8/nginx.conf /etc/nginx/nginx.conf
COPY ./k8/cron/laravel-cron /etc/cron.d/laravel-cron
COPY ./k8/.env.cert ./.env

#Crontab
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron


USER application

#Supervisord
COPY ./k8/supervisord /opt/docker/etc/supervisor.d

#Composer
RUN composer install --no-dev


