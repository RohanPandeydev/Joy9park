#!/bin/sh
set -e

# Render injects $PORT; make Apache listen on it.
PORT="${PORT:-10000}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# If a persistent disk is mounted at wp-content/uploads, make sure Apache can write to it.
if [ -d /var/www/html/wp-content/uploads ]; then
  chown www-data:www-data /var/www/html/wp-content/uploads || true
fi

exec "$@"
