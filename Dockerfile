FROM php:7.3-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer \n\
| php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mysqli

COPY default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

# ENV PORT $PORT

# CMD sed -i “s/80/$PORT/g/” /etc/nginx/conf.d/default.conf
# CMD sed -i 's/80/$PORT/g'  /etc/nginx/conf.d/default.conf