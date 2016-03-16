Docker PHP-FPM 7.0 & Nginx 1.8 on Alpine Linux
==============================================
Example PHP-FPM 7.0 & Nginx 1.8 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 60MB large.


[![Docker Pulls](https://img.shields.io/docker/pulls/trafex/alpine-nginx-php7.svg)](https://hub.docker.com/r/trafex/alpine-nginx-php7/)

Usage
-----
Start the Docker containers:

    sudo docker run -p 80:80 trafex/php-nginx

See the PHP info on http://localhost, or the static html page on http://localhost/test.html

Resources & inspiration
-----------------------
https://ejosh.co/de/2015/09/how-to-link-docker-containers-together

https://github.com/johanan/Ansible-and-Docker
