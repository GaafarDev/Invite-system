# Stage 1: Build the frontend
FROM node:14 as frontend

WORKDIR /app/Frontend

COPY Frontend/package*.json ./

RUN npm install

COPY Frontend/ .

RUN npm run build

# Stage 2: Build the backend
FROM composer:2 as backend

WORKDIR /app/Backend

COPY Backend/composer.json Backend/composer.lock ./

RUN composer install --no-dev --no-scripts --no-progress --prefer-dist

COPY Backend/ .

# Copy the .env.example file and rename it to .env
RUN cp /app/Backend/.env.example /app/Backend/.env

# Debugging step to verify .env file is copied
RUN ls -la /app/Backend

RUN php artisan key:generate

# Copy the built frontend to the backend's public directory
COPY --from=frontend /app/Frontend/dist /app/Backend/public

# Stage 3: Set up the final image
FROM php:8.0-fpm-alpine

WORKDIR /app/Backend

COPY --from=backend /app/Backend /app/Backend

# Install necessary dependencies for pdo_sqlite and build tools
RUN apk --no-cache add sqlite pcre-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add --no-cache php8-pdo php8-pdo_sqlite

# Debugging step to check installed packages
RUN apk info

# Debugging step to check available PHP extensions
RUN php -m

# Copy init.sh to the backend directory
COPY init.sh /app/Backend/

# Update the permissions of init.sh
RUN chmod +x /app/Backend/init.sh


CMD ["sh", "-c", "/app/Backend/init.sh && php artisan serve --host=0.0.0.0 --port=8000"]

