#!/bin/bash
DB_USER="farai"
DB_PASS="@Paradice1"
DB_NAME="amazon"

while read file; do
    echo "Importing $file..."
    mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$file"
done < files_to_import.txt
