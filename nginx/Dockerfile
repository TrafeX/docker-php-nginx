FROM nginx:1.9

COPY nginx.conf /etc/nginx/conf.d/app.conf

CMD /bin/bash -c envsubst < /etc/nginx/conf.d/app.conf.template > /etc/nginx/conf.d/app.conf && nginx -g 'daemon off;'

CMD sed -i 's/UPSTREAM_HOST/'"$UPSTREAM_HOST"'/g' /etc/nginx/conf.d/app.conf \
 && sed -i 's/UPSTREAM_PORT/'"$UPSTREAM_PORT"'/g' /etc/nginx/conf.d/app.conf \
 && nginx -g 'daemon off;'
