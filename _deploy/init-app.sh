#!/bin/sh
set -e

MODE="service"
if [ "$1" = "command-mode" ]; then
    MODE="command"
fi

cd /var/www/html

# if ENVIRONMENT LOCAL, install packages (see Dockerfile.local)
if [ "$APP_ENV" = "local" ]; then
  composer install;

  if [ ! -f "/var/www/html" ]; then
    cp /var/www/html/.env.example /var/www/html/.env
  fi
fi

# clear laravel cache and route
if [ "$APP_ENV" != "local" ]; then
  php artisan config:cache;
  php artisan route:cache;
fi

# permissions
chmod -Rf a+w storage
chmod -Rf a+w bootstrap/cache

# stop php-fpm clearing env variables (default)
# (uncomment option clear_env)
sed -i 's/;clear_env\ =\ no/clear_env\ =\ no/' /etc/php/7.3/php-fpm.d/www.conf

# prepare nginx/default.conf based on environment (local, staging, production)
sed -i -e "s/<root_domain>/$ENV_ROOT_DOMAIN/g" /etc/nginx/conf.d/default.conf
if [ "$APP_ENV" = "local" ]; then
    sed -i -e 's/#localhost $http_origin/localhost $http_origin/g' /etc/nginx/conf.d/default.conf
fi

# run migrations (if not a command/job)
# different user (database config) on AWS
# (user with access to create/drop tables)
if [ "$MODE" != "command" ]; then
  if [ "$APP_ENV" = "local" ]; then
    php artisan migrate
  else
    php artisan migrate --database=mysql_migrations --force
  fi
fi
