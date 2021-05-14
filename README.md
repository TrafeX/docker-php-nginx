# Docker PHP-FPM 7.3 & Nginx 1.18 on Alpine Linux
Example PHP-FPM 7.3 & Nginx 1.18 setup for Docker, build on [Alpine Linux](https://www.alpinelinux.org/). This image is optimized for mediawiki 1.35.0++

Originally forked from: https://github.com/TrafeX/docker-php-nginx and now here: https://github.com/f-ewald/docker-php-nginx


* Built on the lightweight and secure Alpine Linux distribution
* Very small Docker image size (+/-35MB)
* Uses PHP 7.3 for better performance, lower CPU usage & memory footprint
* Optimized for 100 concurrent users
* Optimized to only use resources when there's traffic (by using PHP-FPM's on-demand PM)
* The servers Nginx, PHP-FPM and supervisord run under a non-privileged user (nobody) to make it more secure
* The logs of all the services are redirected to the output of the Docker container (visible with `docker logs -f <container name>`)
* Follows the KISS principle (Keep It Simple, Stupid) to make it easy to understand and adjust the image to your needs
* Allows up to 100 MB file uploads/post requests
* Install several PHP modules that are needed for mediawiki to run.
* Includes GD


[![Docker Pulls](https://img.shields.io/docker/pulls/fewald/nginx-php7.svg)](https://hub.docker.com/r/fewald/nginx-php7/)
![nginx 1.18.0](https://img.shields.io/badge/nginx-1.18-brightgreen.svg)
![php 7.3](https://img.shields.io/badge/php-7.3-brightgreen.svg)
![License MIT](https://img.shields.io/badge/license-MIT-blue.svg)

## Usage

Start the Docker container:

    docker run -p 8080:8080 fewald/nginx-php7

See the PHP info on http://localhost:8080, or the static html page on http://localhost:8080/test.html

Or mount your own code to be served by PHP-FPM & Nginx

    docker run -p 8080:8080 -v ~/my-codebase:/var/www/html trafex/alpine-nginx-php7

## Configuration
In [config/](config/) you'll find the default configuration files for Nginx, PHP and PHP-FPM.
If you want to extend or customize that you can do so by mounting a configuration file in the correct folder;

Nginx configuration:

    docker run -v "`pwd`/nginx-server.conf:/etc/nginx/conf.d/server.conf" fewald/nginx-php7

PHP configuration:

    docker run -v "`pwd`/php-setting.ini:/etc/php7/conf.d/settings.ini" fewald/nginx-php7

PHP-FPM configuration:

    docker run -v "`pwd`/php-fpm-settings.conf:/etc/php7/php-fpm.d/server.conf" fewald/nginx-php7

_Note; Because `-v` requires an absolute path I've added `pwd` in the example to return the absolute path to the current directory_

