#
# PHP Dependencies
#

FROM php:8.3-cli as vendor

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin

RUN install-php-extensions ldap zip pcntl

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY app /app/app
COPY database /app/database
COPY helpers /app/helpers/
COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

WORKDIR /app

RUN composer install --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts --classmap-authoritative

#
# NPM Dependencies
#

FROM node:20.16.0 as frontend

RUN mkdir -p /app/public

# COPY package.json vite.config.js tailwind.config.js postcss.config.js pnpm-lock.yaml /app/
COPY package.json vite.config.js pnpm-lock.yaml /app/
COPY resources/ /app/resources/

WORKDIR /app

RUN npm install -g pnpm

RUN pnpm install && pnpm run build

#
# Application container
#

FROM serversideup/php:8.3-fpm-nginx

# Add LDAP and PostgreSQL extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.3-ldap php8.3-pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Copies the Laravel app, but skips the ignored files and paths
COPY --chown=9999:9999 . .
COPY --chown=9999:9999 --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --chown=9999:9999 --from=frontend /app/public/ /var/www/html/public/
