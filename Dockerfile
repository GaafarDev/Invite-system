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

# Install necessary dependencies for pdo_sqlite
RUN apk --no-cache add sqlite pcre-dev

# Debugging step to check installed packages
RUN apk info

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Debugging step to check available PHP extensions
RUN php -m

COPY init.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init.sh

CMD ["sh", "-c", "init.sh && php artisan serve --host=0.0.0.0 --port=8000"]
