#!/bin/bash

# Ensure the database directory exists
mkdir -p /app/Backend/database

# Debugging: List the directory before creating the database file
echo "Before creating the database.sqlite:"
ls -la /app/Backend/database

# Create the SQLite database file if it does not exist
if [ ! -f /app/Backend/database/database.sqlite ]; then
    touch /app/Backend/database/database.sqlite
fi

# Set the correct permissions for the SQLite database
chmod 777 /app/Backend/database/database.sqlite

# Debugging: List the directory after creating the database file
echo "After creating the database.sqlite:"
ls -la /app/Backend/database

# Debugging: Print the contents of the .env file
echo "Contents of .env file:"
cat /app/Backend/.env

# Debugging: Clear and cache the Laravel configuration
php artisan config:clear
php artisan config:cache

# Debugging: Check the SQLite database path configuration
php artisan db:check-path

# Debugging: List contents of the database directory
echo "Contents of /app/Backend/database before migration:"
ls -la /app/Backend/database

# Run Laravel migrations
php artisan migrate --force

# Debugging: List contents of the database directory again to confirm the database file is created
echo "Contents of /app/Backend/database after migration:"
ls -la /app/Backend/database

# Start the Laravel server
php artisan serve --host=0.0.0.0 --port=8000

