FROM php:7.2-apache-stretch

RUN apt-get update &&\
    apt-get install -y\
        libpq-dev\
        libicu-dev\
        zlib1g-dev\
        git\
        &&\
    docker-php-ext-install\
        pdo\
        pdo_pgsql\
        pdo_mysql\
        intl\
        zip\
        &&\
    pecl install apcu &&\
    echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini
