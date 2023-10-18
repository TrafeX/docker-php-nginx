ARG ARCH=
FROM ${ARCH}alpine:3.18

LABEL Maintainer="Ernesto Serrano <info@ernesto.es>" \
      Description="Lightweight container with Nginx & PHP-FPM based on Alpine Linux."

# Install packages
RUN apk --no-cache add \
        php82 \
        php82-fpm \
        php82-opcache \
        php82-pecl-apcu \
        php82-mysqli \
        php82-pgsql \
        php82-json \
        php82-openssl \
        php82-curl \
        php82-zlib \
        php82-soap \
        php82-xml \
        php82-fileinfo \
        php82-phar \
        php82-intl \
        php82-dom \
        php82-xmlreader \
        php82-ctype \
        php82-session \
        php82-iconv \
        php82-tokenizer \
        php82-zip \
        php82-simplexml \
        php82-mbstring \
        php82-gd \
        nginx \
        runit \
        curl \
# Bring in gettext so we can get `envsubst`, then throw
# the rest away. To do this, we need to install `gettext`
# then move `envsubst` out of the way so `gettext` can
# be deleted completely, then move `envsubst` back.
    && apk add --no-cache --virtual .gettext gettext \
    && mv /usr/bin/envsubst /tmp/ \
    && runDeps="$( \
        scanelf --needed --nobanner /tmp/envsubst \
            | awk '{ gsub(/,/, "\nso:", $2); print "so:" $2 }' \
            | sort -u \
            | xargs -r apk info --installed \
            | sort -u \
    )" \
    && apk add --no-cache $runDeps \
    && apk del .gettext \
    && mv /tmp/envsubst /usr/local/bin/ \
# Remove alpine cache
    && rm -rf /var/cache/apk/* \
# Remove default server definition
    && rm /etc/nginx/http.d/default.conf \
# Make sure files/folders needed by the processes are accessable when they run under the nobody user
    && chown -R nobody.nobody /run \
    && chown -R nobody.nobody /var/lib/nginx \
    && chown -R nobody.nobody /var/log/nginx

# Add configuration files
COPY --chown=nobody rootfs/ /

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html

# Expose the port nginx is reachable on
EXPOSE 8080

# Let runit start nginx & php-fpm
CMD [ "/bin/docker-entrypoint.sh" ]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping

ENV client_max_body_size=2M \
    clear_env=no \
    allow_url_fopen=On \
    allow_url_include=Off \
    display_errors=Off \
    file_uploads=On \
    max_execution_time=0 \
    max_input_time=-1 \
    max_input_vars=1000 \
    memory_limit=128M \
    post_max_size=8M \
    upload_max_filesize=2M \
    zlib_output_compression=On
