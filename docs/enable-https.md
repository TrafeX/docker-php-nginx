# Adding support for HTTPS/SSL

> All the following instructions should be adapted to your personal needs

If your plan to work locally only, first generate your self-signed cert and key:

```bash
openssl req -x509 -nodes -newkey rsa:2048 -keyout https.key -out https.crt -subj "/CN=localhost" -days 5000
```

Then copy your cert files on build stage of your Dockerfile:

```Dockerfile
FROM trafex/php-nginx:latest

# ...

COPY https.crt /etc/nginx/ssl/default.crt
COPY https.key /etc/nginx/ssl/default.key

# ...

```

Edit your nginx.conf file.

> Check [Nginx configuration](../config/nginx.conf) for more help:


```nginx
server {
    listen [::]:443 ssl;
    listen 443 ssl;
    server_name localhost;
    root /var/www/html/public;

    ssl_certificate /etc/nginx/ssl/default.crt;
    ssl_certificate_key /etc/nginx/ssl/default.key;

    # ... the rest here
}
```

If you use docker-compose here is an example:

```yaml
  php-nginx:
    build: ./api
    networks: [ backend ]
    ports: [ "443:443" ]
    working_dir: /var/www/html
    volumes:
      - ./api:/var/www/html
      - ./api/nginx.conf:/etc/nginx/conf.d/default.conf
    restart: on-failure

```

Finally rebuild and restart your docker/compose.
