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
	sed -i 's/;ffi.enable=preload/ffi.enable=preload/' /usr/local/etc/php/php.ini

# From: library/Dockerfile
COPY --from=golang-poc-builder /go/libgolangutil.so ./extension/
COPY php-7.4/extension ./extension
COPY php-7.4/test.php example/example.* ./
