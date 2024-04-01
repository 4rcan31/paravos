#!/bin/bash
#
# Instalacion de la app (manualmente) luego de tener el entorno preparado


if [[ $EUID -ne 0 ]]; then
   echo "Este script debe ejecutarse como root" 
   exit 1
fi

export DEBIAN_FRONTEND=noninteractive

git clone --config http.sslVerify=false https://github.com/4rcan31/paravos.git  /var/www/
cd /var/www
mv public html

# Configurar el .env
#
rm .env

echo "
APP_NAME=Sao
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_PORT=8080
APP_ADDRESS=\"127.0.0.1\"
APP_KEY=7a4bd04541c36b406506b28376aafcbdc8c7a0fe45076ffb5b8b10476be3f5a6

DB_CONNECTION=mysql
DB_HOST=localhost   
DB_PORT=3306
DB_DATABASE=paravos

DB_USERNAME=paravosapp
DB_PASSWORD=password123
DB_ADMIN_USERNAME=root
DB_ADMIN_PASSWORD=
" >> .env

## Ejecutar migraciones e inicializar la app

php jenu execute:migrations

a2enmod rewrite
systemctl restart apache2
