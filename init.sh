#!/bin/bash

# Create the SQLite database file
touch Backend/database/database.sqlite

# Run Laravel migrations
php Backend/artisan migrate --force
