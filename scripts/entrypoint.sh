#!/bin/bash

set -e

# Install dependencies
composer install

# Generate keys and cache configuration
php artisan key:generate
php artisan config:cache

# Grant database privileges
echo "GRANT ALL ON laravel_web.* TO 'convertedIn'@'%' IDENTIFIED BY 'P@ssword';" \
    | mysql -u root -p"password" \
    && echo "GRANT ALL ON test_database.* TO 'convertedIn'@'%' IDENTIFIED BY 'P@ssword'; FLUSH PRIVILEGES;" \
    | mysql -u root -p"password" --database=mysql_testing

# Run migrations and seed database
php artisan migrate --database=mysql
php artisan migrate --database=mysql_testing

# Run the database seed if it hasn't already been run
if [ ! -f /var/www/html/.seed_complete ]; then
    php artisan db:seed
    touch /var/www/html/.seed_complete
fi


# Run the original command
exec "$@"