FROM golang:1.13

ARG PCRE_VERSION=8.00

# Install pcre
RUN cd /root && \
	wget -q https://ftp.pcre.org/pub/pcre/pcre-${PCRE_VERSION}.tar.gz -O - | tar -xz && \
	cd pcre-${PCRE_VERSION} && \
	CFLAGS='-O2 -Wall' ./configure --prefix=/opt/local && \
	make && \
	make install
RUN apt-get update && apt-get install -y swig3.0 swig php7.3-dev php7.3-cli

RUN sed -i 's/enable_dl = Off/enable_dl = On/' /etc/php/7.3/cli/php.ini
RUN echo "extension=example.so" > /etc/php/7.3/cli/conf.d/example.ini

#VOLUME /go/poc-go-in-php
WORKDIR /go/poc-go-in-php
ADD . .
# 1. Build Golang to the shaed library
RUN go build -o wrapper/libimgutil.so -buildmode=c-shared library/main.go
# 2. Build swig code
RUN cd wrapper && swig -php7 example.i && \
    	gcc `php-config --includes` \
    	 	-L. -limgutil \
    	 	-fpic -c example_wrap.c example.c && \
    	gcc -v -L. -limgutil \
    		-shared example_wrap.o example.o \
    		-o example.so
RUN cd wrapper && \
	export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:/usr/lib/php/20180731/ && \
	cp *.so /usr/lib/php/20180731/ && \
	ls -la /usr/lib/php/20180731/ && \
 	php test.php