FROM d4rkghost47/paravos-server-ecommerce:1.0.0

ENV DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www

COPY . /var/www

RUN cd /var/www
RUN mv public html

RUN apt-get update -y  && apt-get install -y netcat 

# RUN php jenu check:connection:mysql
# RUN php jenu execute:migrations



# Copia el script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Otorga permisos de ejecución al script de entrada
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
RUN a2enmod rewrite

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
