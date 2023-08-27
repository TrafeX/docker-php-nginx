# Adding composer

If you need [Composer](https://getcomposer.org/) in your project, here's an easy way to add it.

```Dockerfile
FROM trafex/php-nginx:latest

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress
```

## Building with composer

If you are building an image with source code in it and dependencies managed by composer then the definition can be improved.
The dependencies should be retrieved by the composer but the composer itself (`/usr/bin/composer`) is not necessary to be included in the image.

```Dockerfile
FROM composer AS composer

# Copying the source directory and install the dependencies with composer
COPY <your_directory>/ /app

# Run composer install to install the dependencies
RUN composer install \
  --optimize-autoloader \
  --no-interaction \
  --no-progress

# Continue stage build with the desired image and copy the source including the dependencies downloaded by composer
FROM trafex/php-nginx:latest
COPY --chown=nginx --from=composer /app /var/www/html
```
