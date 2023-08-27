# Sending e-mails
To be able to use the `mail()` function in PHP you need to install a MTA (Mail Transfer Agent) in the container.

The most simple approach is to install `ssmtp`.

The `ssmtp.conf` file needs to be created based on the [documentation online](https://wiki.archlinux.org/title/SSMTP).

```Dockerfile
FROM trafex/php-nginx:latest

# Install ssmtp
RUN apk add --no-cache ssmtp

# Add configuration
COPY ssmtp.conf /etc/ssmtp/ssmtp.conf
```