
FROM ubuntu
RUN apt-get update
RUN apt-get install -y composer
RUN apt-get install -y curl
RUN apt-get install -y php
RUN apt-get install -y php-intl
RUN apt-get install -y php-mbstring
RUN apt-get install -y php-mysql
RUN apt-get install -y php-xml
RUN apt-get install -y unzip
RUN apt-get install -y zip

RUN mkdir /code
WORKDIR /code
ADD . /code/
CMD composer install
