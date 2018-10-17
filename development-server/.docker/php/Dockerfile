FROM php:7.2-fpm

##<romaricp>##
RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip \
    gnupg gnupg1 gnupg2

RUN docker-php-ext-install mysqli

COPY datetime-conf.ini /usr/local/etc/php/conf.d/datetime-conf.ini
COPY php.ini /etc/php/7.2.3/php.ini
COPY php-fpm-pool.conf /etc/php/7.2.3/pool.d/www.conf

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN ln -fs /usr/share/zoneinfo/Europe/Belgrade /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

WORKDIR /var/www
##</romaricp>##

EXPOSE 9000
CMD ["php-fpm"]
