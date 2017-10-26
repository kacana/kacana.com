FROM php:7.0.24-fpm

RUN echo "nameserver 8.8.8.8" | tee /etc/resolv.conf > /dev/null

RUN apt-get update \
    && apt-get install -y curl openssh-server pdftk supervisor zlib1g-dev libmcrypt-dev \
	&& docker-php-ext-install pdo pdo_mysql zip \
	&& mkdir -p /var/run/sshd /var/log/supervisor \
	&& chmod -R 777 /var/run \
	&& chmod -R 777 /var/log/supervisor

RUN docker-php-ext-install bcmath mcrypt

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

#RUN echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini

COPY audit.conf /etc/supervisor/conf.d/audit.conf

EXPOSE 9000

WORKDIR /app




