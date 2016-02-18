Docker PHP-FPM & Nginx setup
============================
Example PHP-FPM & Nginx setup for Docker using docker-compose.

Usage
-----
Add this to your hosts file:

    127.0.0.1 docker-app.dev

Start the Docker containers:

    docker-compose up

See the PHP info on http://docker-app.dev

Docker Hub
----------
The containers can be found on the Docker hub:

- [trafex/example-appdata](https://hub.docker.com/r/trafex/example-appdata)
- [trafex/example-nginx](https://hub.docker.com/r/trafex/example-nginx)
- [trafex/example-phpfpm](https://hub.docker.com/r/trafex/example-phpfpm)


Resources & inspiration
-----------------------
https://ejosh.co/de/2015/09/how-to-link-docker-containers-together

https://github.com/johanan/Ansible-and-Docker
