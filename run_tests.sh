#!/usr/bin/env sh
apk --no-cache add curl
curl --silent --fail http://127.0.0.1:${INT_PORT}/fpm-ping