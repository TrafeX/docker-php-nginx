# Docker PHP-FPM 7.3 & Nginx 1.16 on Alpine Linux
Example PHP-FPM 7.3 & Nginx 1.16 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 35MB large.

Repository: https://github.com/erseco/alpine-php7-webserver


* Built on the lightweight and secure Alpine Linux distribution
* Very small Docker image size (+/-35MB)
* Uses PHP 7.3 for better performance, lower cpu usage & memory footprint
* Optimized for 100 concurrent users
* Optimized to only use resources when there's traffic (by using PHP-FPM's ondemand PM)
* Use of runit instead of supervisord to reduce memory footprint
* The servers Nginx, PHP-FPM run under a non-privileged user (nobody) to make it more secure
* The logs of all the services are redirected to the output of the Docker container (visible with `docker logs -f <container name>`)
* Follows the KISS principle (Keep It Simple, Stupid) to make it easy to understand and adjust the image to your needs
* Also availabe in Apache flavour: `erseco/alpine-php7-webserver:apache`

[![Docker Pulls](https://img.shields.io/docker/pulls/erseco/alpine-php7-webserver.svg)](https://hub.docker.com/r/erseco/alpine-php7-webserver/)
[![Docker image layers](https://images.microbadger.com/badges/image/erseco/alpine-php7-webserver.svg)](https://microbadger.com/images/erseco/alpine-php7-webserver)
![nginx 1.16.1](https://img.shields.io/badge/nginx-1.16-brightgreen.svg)
![php 7.3](https://img.shields.io/badge/php-7.3-brightgreen.svg)
![License MIT](https://img.shields.io/badge/license-MIT-blue.svg)

## Usage

Start the Docker container:

    docker run -p 80:8080 erseco/alpine-php7-webserver

See the PHP info on http://localhost, or the static html page on http://localhost/test.html

Or mount your own code to be served by PHP-FPM & Nginx

    docker run -p 80:8080 -v ~/my-codebase:/var/www/html erseco/alpine-php7-webserver

## Configuration
In [config/](config/) you'll find the default configuration files for Nginx, PHP and PHP-FPM.
If you want to extend or customize that you can do so by mounting a configuration file in the correct folder;

Nginx configuration:

    docker run -v "`pwd`/nginx-server.conf:/etc/nginx/conf.d/server.conf" erseco/alpine-php7-webserver

PHP configuration:

    docker run -v "`pwd`/php-setting.ini:/etc/php7/conf.d/settings.ini" erseco/alpine-php7-webserver

PHP-FPM configuration:

    docker run -v "`pwd`/php-fpm-settings.conf:/etc/php7/php-fpm.d/server.conf" erseco/alpine-php7-webserver

_Note; Because `-v` requires an absolute path I've added `pwd` in the example to return the absolute path to the current directory_


## Adding composer

If you need composer in your project, here's an easy way to add it;

```dockerfile
FROM erseco/alpine-php7-webserver:latest

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress
```
