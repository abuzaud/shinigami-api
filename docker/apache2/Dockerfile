FROM httpd

# On configure le vhost pour utiliser PHP
RUN mkdir /usr/local/apache2/conf/vhosts
RUN echo 'IncludeOptional /usr/local/apache2/conf/vhosts/*.conf' >> /usr/local/apache2/conf/httpd.conf
ADD shinigami.conf /usr/local/apache2/conf/vhosts

# On active les modules pour PHP FPM
RUN sed -i '/LoadModule proxy_module/s/^#//g' /usr/local/apache2/conf/httpd.conf
RUN sed -i '/LoadModule proxy_fcgi_module/s/^#//g' /usr/local/apache2/conf/httpd.conf

RUN mkdir -p /var/www/shinigami/htdocs
RUN chown -R www-data:www-data /var/www
