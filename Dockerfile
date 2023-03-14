FROM php:7.4-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
#COPY start-apache /usr/local/bin 
#ERROR: failed to calculate checksum of ref ccbt7pxr8ac8nw21xv04croz0::t71k2v0jjfyi4mtztrf0ixfn3: "/start-apache": not found
RUN a2enmod rewrite

# Copy application source
COPY app/public /var/www/ 
#9 ERROR: failed to calculate checksum of ref ccbt7pxr8ac8nw21xv04croz0::t71k2v0jjfyi4mtztrf0ixfn3: "/src": not found
RUN chown -R www-data:www-data /var/www

CMD ["start-apache"]