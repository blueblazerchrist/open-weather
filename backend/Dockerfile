FROM php:8.3.7-fpm
RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libssl-dev \
		libzip-dev \
		zip \
        libxml2-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip soap \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install fileinfo \
    && apt-get update \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install sockets \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis
RUN apt-get install -y supervisor
RUN mkdir -p /var/www/logs/supervisor
RUN apt-get update && apt-get install -y curl netcat-traditional
COPY ./supervisor/conf.d/* /etc/supervisor/conf.d
COPY ./supervisor/supervisord.conf /etc/supervisor/
COPY ./php-fpm/default.ini "$PHP_INI_DIR/conf.d/"
RUN rm -rf /usr/local/etc/php-fpm.d/www.conf
CMD ["bash", "-c", "/usr/local/bin/docker-php-entrypoint php-fpm & /usr/bin/supervisord -c /etc/supervisor/supervisord.conf"]

