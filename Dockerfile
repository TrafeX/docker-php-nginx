FROM debian:jessie

COPY src/ /var/www/html/

VOLUME /var/www/html/
