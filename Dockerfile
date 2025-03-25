FROM php:8.4-apache
WORKDIR /var/www/html
COPY ./alexa-tts/ ./
RUN chown -R www-data:www-data /var/www/html