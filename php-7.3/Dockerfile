FROM golang:1.13 as go-builder
WORKDIR /go
ADD library/main.go main.go
RUN go build -o /go/libimgutil.so -buildmode=c-shared main.go

FROM php:7.3.13-cli as php-builder
WORKDIR /root

RUN apt-get update && \
	apt-get install -y \
		swig \
		swig3.0

COPY --from=go-builder /go/libimgutil.so /go/libimgutil.h ./
COPY ./extension/* ./

RUN swig -php7 example.i && \
	gcc `php-config --includes` \
		-fpic -c example_wrap.c example.c && \
	gcc \
		-v -L. -limgutil \
		-shared example_wrap.o example.o \
		-o example.so

FROM php:7.3.13-cli
WORKDIR /root
ARG LD_LIBRARY_PATH=/usr/local/lib/php/extensions/no-debug-non-zts-20180731
ENV LD_LIBRARY_PATH=$LD_LIBRARY_PATH

RUN echo "extension=example" > /usr/local/etc/php/conf.d/example.ini

COPY --from=php-builder /root/libimgutil.so /root/example.so $LD_LIBRARY_PATH/
COPY test.php icon_128.png ./
RUN php test.php
