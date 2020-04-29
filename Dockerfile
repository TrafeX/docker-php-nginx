FROM alpine:3.11
LABEL Maintainer="Tim de Pater <code@trafex.nl>" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

# Install packages
RUN apk --no-cache add \
        php7 \
        php7-fpm \
        php7-opcache \
        php7-pecl-apcu \
        php7-mysqli \
        php7-pgsql \
        php7-pdo \
        php7-pdo_pgsql \
        php7-pdo_mysql \
        php7-pdo_sqlite \
        php7-json \
        php7-openssl \
        php7-curl \
        php7-zlib \
        php7-bz2 \
        php7-soap \
        php7-xml \
        php7-fileinfo \
        php7-phar \
        php7-intl \
        php7-dom \
        php7-xmlreader \
        php7-ctype \
        php7-session \
        php7-iconv \
        php7-tokenizer \
        php7-xmlrpc \
        php7-zip \
        php7-simplexml \
        php7-mbstring \
        php7-gd \
        nginx \
        runit \
        curl \
    && rm -rf /var/cache/apk/*

# Configure nginx
COPY config/nginx.conf /etc/nginx/nginx.conf
# Remove default server definition
RUN rm /etc/nginx/conf.d/default.conf

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY config/php.ini /etc/php7/conf.d/custom.ini

# Configure runit boot script
COPY config/boot.sh /sbin/boot.sh

# Setup document root
RUN mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html && \
    chown -R nobody.nobody /run && \
    chown -R nobody.nobody /var/lib/nginx && \
    chown -R nobody.nobody /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html
COPY --chown=nobody src/ /var/www/html/

# Add runit boot scripts
COPY --chown=nobody config/nginx.run /etc/service/nginx/run
COPY --chown=nobody config/php.run /etc/service/php/run

# Expose the port nginx is reachable on
EXPOSE 8080

# Let runit start nginx & php-fpm
CMD [ "/sbin/boot.sh" ]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
