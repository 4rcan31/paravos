#!/bin/bash
#
#
apt update -y ; apt install vim -y
if [[ $EUID -ne 0 ]]; then
   echo "Este script debe ejecutarse como root" 
   exit 1
fi

export DEBIAN_FRONTEND=noninteractive


apt install apache2 software-properties-common -y
#Al agregar este repo se esta diciendo que se quiere las 
# creo que se pueden ver las ultimas versiones aca: https://www.php.net/downloads.php
# y todos los paquetes que tiene este repo: https://launchpad.net/~ondrej/+archive/ubuntu/php
add-apt-repository ppa:ondrej/php -y
apt-get update -y
apt-get install php -y
apt install mysql-server -y 
apt install php-cli php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath -y

# Manejo del servicio
apt install systemctl -y

apt install git -y
rm -rf /var/www/html

a2enmod rewrite
systemctl restart apache2

#reescribir el archivo /etc/apache2/sites-available/000-default.conf
rm /etc/apache2/sites-available/000-default.conf
touch /etc/apache2/sites-available/000-default.conf

echo "
<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #ServerName www.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot "/var/www/html"
        <Directory "/var/www/html">
                Options FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>


        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        # For most configuration files from conf-available/, which are
        # enabled or disabled at a global level, it is possible to
        # include a line for only one particular virtual host. For example the
        # following line enables the CGI configuration for this host only
        # after it has been globally disabled with "a2disconf".
        #Include conf-available/serve-cgi-bin.conf
</VirtualHost>
" >>  /etc/apache2/sites-available/000-default.conf


echo "Reiniciando servidor apache"
systemctl reload apache2
systemctl restart apache2
echo "Listo, ya puedes revisar el servidor!"



