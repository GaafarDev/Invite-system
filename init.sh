# init.sh
#!/bin/bash

# Create the SQLite database file
touch backend/database/database.sqlite

# Run Laravel migrations
php backend/artisan migrate --force
