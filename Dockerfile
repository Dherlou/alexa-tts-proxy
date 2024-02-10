FROM php:8.3-apache
WORKDIR /var/www/html
COPY ./alexa-tts ./
RUN chown -R www-data:www-data /var/www/html