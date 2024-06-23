#!/bin/bash

# Create the SQLite database file
touch /app/Backend/database/database.sqlite

# Run Laravel migrations
php artisan migrate --force
