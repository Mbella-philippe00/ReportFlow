#!/usr/bin/env sh
set -eu

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "ReportFlow production caches warmed."
