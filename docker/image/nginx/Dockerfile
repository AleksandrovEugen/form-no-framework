ARG NGINX_IMAGE=nginx:1.21.0-alpine

FROM ${NGINX_IMAGE}

ARG SERVER_NAME=localhost
ARG FPM_ADDR=php
ARG FPM_PORT=9000

COPY ./config/.htpasswd /etc/nginx/
COPY ./config/nginx.conf /etc/nginx/
COPY ./config/vhost.conf /etc/nginx/conf.d/

RUN sed -i "s/___SERVER_NAME___/$SERVER_NAME/g" /etc/nginx/conf.d/vhost.conf \
    && sed -i "s/___FPM_ADDR___/$FPM_ADDR/g" /etc/nginx/conf.d/vhost.conf \
    && sed -i "s/___FPM_PORT___/$FPM_PORT/g" /etc/nginx/conf.d/vhost.conf

RUN adduser -u 82 -D -S -G www-data www-data

CMD ["nginx"]
