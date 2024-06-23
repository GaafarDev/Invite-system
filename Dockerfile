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
COPY Backend/.env.example Backend/.env
RUN php artisan key:generate

# Copy the built frontend to the backend's public directory
COPY --from=frontend /app/Frontend/dist /app/Backend/public

# Stage 3: Set up the final image
FROM php:8.0-fpm-alpine
WORKDIR /app/Backend
COPY --from=backend /app/Backend /app/Backend
RUN apk --no-cache add sqlite pcre-dev
RUN docker-php-ext-install pdo pdo_sqlite
COPY init.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init.sh

CMD ["sh", "-c", "init.sh && php artisan serve --host=0.0.0.0 --port=8000"]
