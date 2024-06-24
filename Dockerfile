# Use multi-stage build for optimized final image

# Stage 1: Build the backend
FROM composer:2 as backend

WORKDIR /app

COPY Backend/composer.json Backend/composer.lock ./

RUN composer install --no-dev --no-scripts --no-progress --prefer-dist

COPY Backend/ .

# Copy the .env.example file and rename it to .env
RUN cp /app/.env.example /app/.env

# Debugging step to verify .env file is copied
RUN ls -la /app

RUN php artisan key:generate

# Stage 2: Set up the final image
FROM php:8.2-fpm-alpine

WORKDIR /app

COPY --from=backend /app /app

# Install necessary dependencies for pdo_sqlite and build tools
RUN apk update && apk add --no-cache sqlite-dev pcre-dev $PHPIZE_DEPS \
    && docker-php-ext-install pdo pdo_sqlite \
    && apk del $PHPIZE_DEPS

# Debugging step to check installed packages
RUN apk info

# Debugging step to check available PHP extensions
RUN php -m

# Copy init.sh script
COPY init.sh /usr/local/bin/init.sh

RUN chmod +x /usr/local/bin/init.sh

CMD ["sh", "/usr/local/bin/init.sh"]
