
FROM ubuntu
RUN apt-get update
RUN apt-get install -y composer
RUN apt-get install -y curl
RUN apt-get install -y php
RUN apt-get install -y php-intl
RUN apt-get install -y php-mbstring
RUN apt-get install -y php-mysql
RUN apt-get install -y php-xml
RUN apt-get install -y php-curl
RUN apt-get install -y unzip
RUN apt-get install -y zip

RUN mkdir /code
WORKDIR /code
RUN sed -i -e "s/;extension=php_openssl.dll/extension=php_openssl.dll/g" /etc/php/7.0/cli/php.ini
CMD composer update
