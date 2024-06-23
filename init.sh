#!/bin/bash

# Create the SQLite database file
touch /app/Backend/database/database.sqlite

# Run Laravel migrations
php artisan migrate --force

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=8000
