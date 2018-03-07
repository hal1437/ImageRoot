
FROM ubuntu
RUN apt-get update

#PHPのインストール
RUN apt-get install -y composer
RUN apt-get install -y curl
RUN apt-get install -y php
RUN apt-get install -y php-intl
RUN apt-get install -y php-mbstring
RUN apt-get install -y php-mysql
RUN apt-get install -y php-xml
RUN apt-get install -y php-curl

RUN apt-get install -y zip
RUN apt-get install -y unzip
RUN apt-get install -y wget

# libpuzzleのインストール
RUN apt-get install -y libgd-dev
RUN wget http://download.pureftpd.org/pub/pure-ftpd/misc/libpuzzle/releases/libpuzzle-0.11.tar.bz2 && \
	tar jxvf libpuzzle-0.11.tar.bz2                                                                && \
	cd libpuzzle-0.11                                                                              && \
	./configure                                                                                    && \
	make                                                                                           && \
	make install
RUN echo "extension=libpuzzle.so" > /etc/php/7.0/cli/php.ini
RUN sed -i -e "s/;extension=php_openssl.dll/extension=php_openssl.dll/g" /etc/php/7.0/cli/php.ini

RUN mkdir /code
WORKDIR /code
CMD composer update
