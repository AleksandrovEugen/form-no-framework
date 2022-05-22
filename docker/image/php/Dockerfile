ARG PHP_IMAGE=php:8.0.6-fpm

FROM ${PHP_IMAGE}

ARG UID=1000
ARG UPLOAD_MAX_FILESIZE=100M
ARG POST_MAX_SIZE=110M
ARG MEMORY_LIMIT=1G

# Setup
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            git \
            imagemagick \
            libzip-dev \
            zip \
            unzip \
            libmagickwand-dev \
            libmemcached-dev \
            libz-dev \
            libpq-dev \
            libjpeg-dev \
            libpng-dev \
            libfreetype6-dev \
            libssl-dev \
            libgmp-dev \
            libmcrypt-dev \
            libonig-dev; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    docker-php-ext-configure gd --prefix=/usr --with-jpeg --with-freetype \
    && docker-php-ext-install gd pdo_mysql zip bcmath gmp pcntl opcache intl exif \
    && docker-php-source delete

# Install Xdebug
RUN docker-php-source extract \
    && pecl install -o -f xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./config/xdebug.ini /usr/local/etc/php/conf.d/xdebug-dev.ini
COPY ./config/www.conf /usr/local/etc/php-fpm.d
RUN sed -i -E "s/upload_max_filesize = [0-9]+M/upload_max_filesize = $UPLOAD_MAX_FILESIZE/g" $PHP_INI_DIR/php.ini \
    && sed -i -E "s/post_max_size = [0-9]+M/post_max_size = $POST_MAX_SIZE/g" $PHP_INI_DIR/php.ini \
    && sed -i -E "s/memory_limit = [0-9]+M/memory_limit = $MEMORY_LIMIT/g" $PHP_INI_DIR/php.ini

# Install Composer
RUN export COMPOSER_ALLOW_SUPERUSER=1

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --filename=composer --install-dir=/usr/local/bin/ && \
    php -r "unlink('composer-setup.php');"

# Add user
RUN adduser --disabled-password --gecos "" --no-create-home --ingroup www-data --uid ${UID} user
RUN mkdir -p /home/user/.composer/ && \
    chown user:www-data /home/user/.composer/

###########################################################################
# ImageMagick:
###########################################################################

USER root

ARG INSTALL_IMAGEMAGICK=false
ARG IMAGEMAGICK_VERSION=latest
ENV IMAGEMAGICK_VERSION ${IMAGEMAGICK_VERSION}

RUN if [ ${INSTALL_IMAGEMAGICK} = true ]; then \
    apt-get install -yqq libmagickwand-dev imagemagick && \
    if [ $(php -r "echo PHP_MAJOR_VERSION;") = "8" ]; then \
      cd /tmp && \
      if [ ${IMAGEMAGICK_VERSION} = "latest" ]; then \
        git clone https://github.com/Imagick/imagick; \
      else \
        git clone --branch ${IMAGEMAGICK_VERSION} https://github.com/Imagick/imagick; \
      fi && \
      cd imagick && \
      phpize && \
      ./configure && \
      make && \
      make install && \
      rm -r /tmp/imagick; \
    else \
      pecl install imagick; \
    fi && \
    docker-php-ext-enable imagick; \
    php -m | grep -q 'imagick' \
;fi


USER user

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm", "--nodaemonize"]
