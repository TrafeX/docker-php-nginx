Docker PHP-FPM 7.2 & Nginx 1.14 on Alpine Linux
==============================================
Example PHP-FPM 7.2 & Nginx 1.14 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 35MB large.


[![Docker Pulls](https://img.shields.io/docker/pulls/trafex/alpine-nginx-php7.svg)](https://hub.docker.com/r/trafex/alpine-nginx-php7/)

Usage
-----
Start the Docker containers:

    docker run -p 80:80 trafex/alpine-nginx-php7

See the PHP info on http://localhost, or the static html page on http://localhost/test.html
