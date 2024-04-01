# Usa la imagen oficial de MySQL como base
FROM mysql:latest

# Copia el script SQL al directorio /docker-entrypoint-initdb.d/ en la imagen
COPY init.sql /docker-entrypoint-initdb.d/

# Define variables de entorno para la creación del usuario y la base de datos
ENV MYSQL_ALLOW_EMPTY_PASSWORD=true
ENV MYSQL_DATABASE=paravos
ENV MYSQL_USER=paravosapp
ENV MYSQL_PASSWORD=password123
