#
# Stage 1: PNPM dependencies as public
#
FROM node:20-slim as public
ENV PNPM_HOME="/pnpm"
ENV PATH="${PNPM_HOME}:$PATH"
RUN corepack enable

# COPY package.json vite.config.js tailwind.config.js postcss.config.js pnpm-lock.yaml /app/
COPY package.json vite.config.js tailwind.config.js postcss.config.js pnpm-lock.yaml /app/
COPY resources/ /app/resources/

WORKDIR /app
RUN --mount=type=cache,id=pnpm,target=/pnpm/store pnpm install --frozen-lockfile
RUN pnpm run build

#
# Stage 2: Composer dependencies as vendor
#
FROM serversideup/php:8.3-cli as vendor

COPY --chown=www-data:www-data . /var/www/html

RUN composer install --no-interaction --optimize-autoloader --no-dev

#
# Web App
#
FROM serversideup/php:8.3-fpm-nginx-alpine as webapp

ARG build=develop

ENV BUILD ${build}
ENV PHP_OPCACHE_ENABLE=1

USER www-data

COPY  --from=vendor --chown=www-data:www-data /var/www/html /var/www/html
COPY  --from=public --chown=www-data:www-data /app/public /var/www/html/public
