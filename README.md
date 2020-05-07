# Docker PHP-FPM 7.3 & Nginx 1.16 on Alpine Linux
Example PHP-FPM 7.3 & Nginx 1.16 setup for Docker, build on [Alpine Linux](http://www.alpinelinux.org/).
The image is only +/- 25MB large.

Repository: https://github.com/erseco/alpine-php7-webserver


* Built on the lightweight and secure Alpine Linux distribution
* Very small Docker image size (+/-25MB)
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


## Adding additional daemons
You can add additional daemons (e.g. your own app) to the image by creating runit entries. You only have to write a small shell script which runs your daemon, and runit will keep it up and running for you, restarting it when it crashes, etc.

The shell script must be called `run`, must be executable, and is to be placed in the directory `/etc/service/<NAME>`.

Here's an example showing you how a memcached server runit entry can be made.

    #!/bin/sh
    ### In memcached.sh (make sure this file is chmod +x):
    # `chpst -u memcache` runs the given command as the user `memcache`.
    # If you omit that part, the command will be run as root.
    exec 2>&1 chpst -u memcache /usr/bin/memcached

    ### In Dockerfile:
    RUN mkdir /etc/service/memcached
    ADD memcached.sh /etc/service/memcached/run

Note that the shell script must run the daemon **without letting it daemonize/fork it**. Usually, daemons provide a command line flag or a config file option for that.


## Running scripts during container startup
You can set your own scripts during startup, just add your scripts in `/docker-entrypoint-init.d/`. The scripts are run in lexicographic order.

All scripts must exit correctly, e.g. with exit code 0. If any script exits with a non-zero exit code, the booting will fail.

The following example shows how you can add a startup script. This script simply logs the time of boot to the file /tmp/boottime.txt.

    #!/bin/sh
    ### In logtime.sh (make sure this file is chmod +x):
    date > /tmp/boottime.txt

    ### In Dockerfile:
    ADD logtime.sh /docker-entrypoint-init.d/logtime.sh


## Configuration
In [rootfs/etc/](rootfs/etc/) you'll find the default configuration files for Nginx, PHP and PHP-FPM.
If you want to extend or customize that you can do so by mounting a configuration file in the correct folder;

Nginx configuration:

    docker run -v "`pwd`/nginx-server.conf:/etc/nginx/conf.d/server.conf" erseco/alpine-php7-webserver

PHP configuration:

    docker run -v "`pwd`/php-setting.ini:/etc/php7/conf.d/settings.ini" erseco/alpine-php7-webserver

PHP-FPM configuration:

    docker run -v "`pwd`/php-fpm-settings.conf:/etc/php7/php-fpm.d/server.conf" erseco/alpine-php7-webserver

_Note; Because `-v` requires an absolute path I've added `pwd` in the example to return the absolute path to the current directory_

## Environment variables

You can define the next environment variables to change values from NGINX and PHP

| Server | Variable Name           | Default | description                                                                                                                                                                                                                                            |
|--------|-------------------------|---------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| NGINX  | client_max_body_size    | 2m      | Sets the maximum allowed size of the client request body, specified in the “Content-Length” request header field.                                                                                                                                      |
| PHP7   | allow_url_fopen         | On      | This option enables the URL-aware fopen wrappers that enable accessing URL object like files. Default wrappers are provided for the access of remote files using the ftp or http protocol, some extensions like zlib may register additional wrappers. |
| PHP7   | allow_url_include       | Off     | This option allows the use of URL-aware fopen wrappers with the following functions: include(), include_once(), require(), require_once().                                                                                                             |
| PHP7   | display_errors          | Off     | This determines whether errors should be printed to the screen as part of the output or if they should be hidden from the user.                                                                                                                        |
| PHP7   | file_uploads            | On      | Whether or not to allow HTTP file uploads.                                                                                                                                                                                                             |
| PHP7   | max_execution_time      | 0       | This sets the maximum time in seconds a script is allowed to run before it is terminated by the parser. This helps prevent poorly written scripts from tying up the server. The default setting is 30.                                                 |
| PHP7   | max_input_time          | -1      | This sets the maximum time in seconds a script is allowed to parse input data, like POST, GET and file uploads.                                                                                                                                        |
| PHP7   | max_input_vars          | 1000    | This sets the maximum number of input variables allowed per request and can be used to deter denial of service attacks involving hash collisions on the input variable names.                                                                          |
| PHP7   | memory_limit            | 128M    | This sets the maximum amount of memory in bytes that a script is allowed to allocate. This helps prevent poorly written scripts for eating up all available memory on a server. Note that to have no memory limit, set this directive to -1.           |
| PHP7   | post_max_size           | 8M      | Sets max size of post data allowed. This setting also affects file upload. To upload large files, this value must be larger than upload_max_filesize. Generally speaking, memory_limit should be larger than post_max_size.                            |
| PHP7   | upload_max_filesize     | 2M      | The maximum size of an uploaded file.                                                                                                                                                                                                                  |
| PHP7   | zlib.output_compression | On      | Whether to transparently compress pages. If this option is set to "On" in php.ini or the Apache configuration, pages are compressed if the browser sends an "Accept-Encoding: gzip" or "deflate" header.                                               |



## Adding composer

If you need composer in your project, here's an easy way to add it;

```dockerfile
FROM erseco/alpine-php7-webserver:latest
USER root
# Install composer from the official image
RUN apk add --no-cache composer
USER nobody
# Run composer install to install the dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress
```
