
FROM ubuntu
RUN apt-get -y update
RUN apt-get -y upgrade

#PHPのインストール
RUN apt-get install -y composer curl php php-intl php-mbstring php-mysql php-xml php-curl php-dev
RUN apt-get install -y zip unzip wget gcc g++ 

# libpuzzleのインストール
RUN apt-get install -y libgd-dev
RUN wget --no-check-certificate https://github.com/kkirby/libpuzzle/archive/feature/PHP7-Comptability.zip && \
	unzip PHP7-Comptability.zip                                                                           && \
	cd libpuzzle-feature-PHP7-Comptability                                                                && \
	autoreconf --install                                                                                  && \
	./configure                                                                                           && \
	make                                                                                                  && \
	make install                                                                                          && \
	cd php/libpuzzle                                                                                      && \
	phpize                                                                                                && \
	./configure --with-libpuzzle                                                                          && \
	make                                                                                                  && \
	make install

RUN echo "extension=libpuzzle.so" >> /etc/php/7.0/cli/php.ini

RUN sed -i -e "s/;extension=php_openssl.dll/extension=php_openssl.dll/g" /etc/php/7.0/cli/php.ini
RUN mkdir /image_tmp
WORKDIR /root/
CMD composer update
