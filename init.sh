#!/bin/bash

# Create the SQLite database file
touch database/database.sqlite

# Run Laravel migrations
php artisan migrate --force
