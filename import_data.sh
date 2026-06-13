#!/bin/bash
DB_USER="root"
DB_PASS="root"
DB_NAME="amazon_dev"

while read file; do
    echo "Importing $file..."
    docker exec -i ubuntu-php-db mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$file"
done < files_to_import.txt
