#!/bin/bash

echo "Importing database..."
mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS serie_a;"
mysql -u root -p"$MYSQL_ROOT_PASSWORD" serie_a < /docker-entrypoint-initdb.d/db.sql
echo "Database imported successfully!"
