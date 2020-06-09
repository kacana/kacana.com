FROM php:7.0.24-fpm

RUN echo "nameserver 8.8.8.8" | tee /etc/resolv.conf > /dev/null

RUN apt-get update \
    && apt-get install -y curl openssh-server pdftk supervisor zlib1g-dev libmcrypt-dev libpng-dev imagemagick\
	&& docker-php-ext-install pdo pdo_mysql zip \
	&& mkdir -p /var/run/sshd /var/log/supervisor \
	&& chmod -R 777 /var/run \
	&& chmod -R 777 /var/log/supervisor

RUN docker-php-ext-install bcmath mcrypt gd

#RUN echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini

COPY audit.conf /etc/supervisor/conf.d/audit.conf

EXPOSE 9000

WORKDIR /app




