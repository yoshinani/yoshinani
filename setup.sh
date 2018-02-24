#!/usr/bin/env bash -eu

cd `dirname $0`
cp .env.example .env
# Install composer
composer install
# Generate key
php artisan key:generate
# Create ide-helper
php artisan ide-helper:generate 1>/dev/null 2>/dev/null
# Run migration
php artisan migrate 1>/dev/null 2>/dev/null
echo "Application setting succeeded"