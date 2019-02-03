# Docker PHP-FPM 7.2 & Nginx 1.14 on Alpine Linux
Example PHP-FPM 7.2 & Nginx 1.14 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 35MB large.

Repository: https://github.com/TrafeX/docker-php-nginx


* Built on the lightweight and secure Alpine Linux distribution
* Very small Docker image size (+/-35MB)
* Uses PHP 7.2 for better performance, lower cpu usage & memory footprint
* Optimized for 100 concurrent users
* Optimized to only use resources when there's traffic (by using PHP-FPM's ondemand PM)
* The servers Nginx, PHP-FPM and supervisord run under a non-privileged user (nobody) to make it more secure
* The logs of all the services are redirected to the output of the Docker container (visible with `docker logs -f <container name>`)
* Follows the KISS principle (Keep It Simple, Stupid) to make it easy to understand and adjust the image


[![Docker Pulls](https://img.shields.io/docker/pulls/trafex/alpine-nginx-php7.svg)](https://hub.docker.com/r/trafex/alpine-nginx-php7/)
[![Docker image layers](https://images.microbadger.com/badges/image/trafex/alpine-nginx-php7.svg)](https://microbadger.com/images/trafex/alpine-nginx-php7)
![nginx 1.14.1](https://img.shields.io/badge/nginx-1.14-brightgreen.svg)
![php 7.2](https://img.shields.io/badge/php-7.2-brightgreen.svg)
![License MIT](https://img.shields.io/badge/license-MIT-blue.svg)

### Breaking changes (26/01/2019)

Please note that the new builds since 26/01/2019 are exposing a different port to access Nginx.
To be able to run Nginx as a non-privileged user, the port it's running on needed
to change to a non-privileged port (above 1024).

The last build of the old version that exposed port 80 was `trafex/alpine-nginx-php7:ba1dd422`

## Usage

Start the Docker container:

    docker run -p 80:8080 trafex/alpine-nginx-php7

See the PHP info on http://localhost, or the static html page on http://localhost/test.html
