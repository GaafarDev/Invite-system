# Stage 1: Build the frontend
FROM node:14.17.0 as frontend
WORKDIR /app/frontend
COPY frontend/package*.json ./
RUN npm install
COPY frontend/ .
RUN npm run build

# Stage 2: Build the backend
FROM composer:2.1 as backend
WORKDIR /app/backend
COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --no-scripts --no-progress --prefer-dist
COPY backend/ .
RUN php artisan key:generate

# Copy the built frontend to the backend's public directory
COPY --from=frontend /app/frontend/dist /app/backend/public

# Stage 3: Set up the final image
FROM php:8.0.6-fpm-alpine
WORKDIR /app/backend
COPY --from=backend /app/backend /app/backend
RUN apk --no-cache add sqlite
COPY init.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init.sh

CMD ["sh", "-c", "init.sh && php artisan serve --host=0.0.0.0 --port=8000"]
