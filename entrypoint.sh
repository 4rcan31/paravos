#!/bin/bash

# Espera a que la base de datos esté disponible
while ! nc -z paravos-db 3306; do
  echo 'Esperando a que la base de datos este lista...'
  sleep 1
done

# Ejecuta las migraciones
php jenu check:connection:mysql
php jenu execute:migrations

apache2ctl -D FOREGROUND

# Espera indefinidamente para mantener el contenedor en ejecución
tail -f /dev/null
