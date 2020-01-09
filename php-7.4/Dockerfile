FROM golang:1.13 as go-builder
WORKDIR /go
ADD library/main.go main.go
RUN go build -o /go/libimgutil.so -buildmode=c-shared main.go

# https://www.php.net/manual/ffi.examples-complete.php
FROM php:7.4.1-cli
WORKDIR /root
ENV LD_LIBRARY_PATH=/root/extension

RUN apt-get update && \
	apt-get install -y \
		libffi-dev && \
	docker-php-ext-install ffi && \
	rm -rf /var/lib/apt/lists/*

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
	sed -i 's/;opcache.preload=/opcache.preload=\/root\/extension\/preload.php/' /usr/local/etc/php/php.ini && \
	sed -i 's/;ffi.enable=preload/ffi.enable=preload/' /usr/local/etc/php/php.ini

COPY extension ./extension
COPY --from=go-builder /go/libimgutil.so ./extension/
COPY test.php icon_128.png ./
RUN php test.php
