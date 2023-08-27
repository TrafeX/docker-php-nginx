# Adding xdebug support

Create the following file `xdebug.ini`

```ini
zend_extension=xdebug.so
xdebug.mode=develop,debug
xdebug.discover_client_host=true
xdebug.start_with_request=yes
xdebug.trigger_value=PHPSTORM
xdebug.log_level=0

xdebug.var_display_max_children=10
xdebug.var_display_max_data=10
xdebug.var_display_max_depth=10

xdebug.client_host=host.docker.internal
xdebug.client_port=9003
```

Create a new image with the following `Dockerfile`

```Dockerfile
FROM trafex/php-nginx:latest

# Temporary switch to root
USER root

# Install xdebug
RUN apk add --no-cache php82-pecl-xdebug

# Add configuration
COPY xdebug.ini ${PHP_INI_DIR}/conf.d/xdebug.ini

# Switch back to non-root user
USER nobody
```
