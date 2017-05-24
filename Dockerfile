FROM phpdockerio/php7-fpm

# Install dependencies
RUN apt-get -y update && \
    apt-get -y install curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get -y --no-install-recommends install  php7.0-mbstring && \
    apt-get -y --no-install-recommends install  php7.0-mysql && \
    apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN mkdir app

COPY js/ /app/js
COPY src/ /app/src
COPY composer.json/ /app/composer.json
COPY composer.lock/ /app/composer.lock
COPY index.php/ /app/index.php
COPY cli-config.php/ /app/cli-config.php
COPY php-ini-overrides.ini /etc/php/7.0/fpm/conf.d/99-overrides.ini

# Install app dependencies
RUN cd /app && \
    composer install --no-interaction

EXPOSE 8000

ENTRYPOINT cd /app && \
           /usr/local/bin/composer run