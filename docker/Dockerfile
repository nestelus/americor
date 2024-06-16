FROM richarvey/nginx-php-fpm

ADD ../app /var/www/app


RUN rm -Rf /etc/nginx/sites-enabled/*

ADD ../docker/conf/nginx/site.conf /etc/nginx/sites-available/site.conf

ADD ../docker/conf/php/php.ini /usr/local/etc/php/conf.d/99.ini

WORKDIR /var/www/app

RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
