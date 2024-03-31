FROM d4rkghost47/paravos-server-ecommerce:1.0.0

ENV DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www

COPY . /var/www

RUN cd /var/www
RUN mv public html

# RUN php jenu check:connection:mysql
# RUN php jenu execute:migrations

EXPOSE 80
RUN a2enmod rewrite

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
