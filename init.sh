#!/bin/bash

# Ensure the database directory exists
mkdir -p /app/Backend/database

# Create the SQLite database file
touch /app/Backend/database/database.sqlite

# List contents of the database directory
ls -la /app/Backend/database

# Run Laravel migrations
php artisan migrate --force

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=8000
