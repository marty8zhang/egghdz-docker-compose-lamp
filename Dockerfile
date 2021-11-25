FROM egghdz/docker-php-apache:latest

COPY ./configuration/custom.ini $PHP_INI_DIR/conf.d/

ARG uid=33
ARG gid=33

RUN usermod -u $uid www-data \
    && groupmod -g $gid www-data
