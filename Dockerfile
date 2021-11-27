FROM egghdz/docker-php-apache:latest

COPY ./configuration/custom.ini $PHP_INI_DIR/conf.d/

# Work around mount volume permission issues.
ARG uid=33
ARG gid=33
RUN usermod -u $uid www-data \
    && groupmod -g $gid www-data

# Work around container internal communication issue when the host is using a non-80 port.
ARG http_port=80
RUN if [ $http_port != "80" ] ;\
    then sed -i "/Listen 80/ a Listen $http_port" /etc/apache2/ports.conf \
           && sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:80 \*:$http_port>/" \
             /etc/apache2/sites-enabled/000-default.conf ; \
    fi
