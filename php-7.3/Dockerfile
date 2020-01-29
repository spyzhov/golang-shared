FROM php:7.3.13-cli as php-builder
WORKDIR /root

RUN apt-get update && \
	apt-get install -y \
		swig \
		swig3.0

# From: library/Dockerfile
COPY --from=golang-poc-builder /go/libgolangutil.so /go/libgolangutil.h ./
COPY ./php-7.3/extension/example.* ./

RUN swig -php7 example.i && \
	gcc `php-config --includes` \
		-fpic -c example_wrap.c example.c && \
	gcc \
		-v -L. -lgolangutil \
		-shared example_wrap.o example.o \
		-o example.so

FROM php:7.3.13-cli
WORKDIR /root
EXPOSE 8080
ARG LD_LIBRARY_PATH=/usr/local/lib/php/extensions/no-debug-non-zts-20180731
ENV LD_LIBRARY_PATH=$LD_LIBRARY_PATH

RUN echo "extension=example" > /usr/local/etc/php/conf.d/example.ini

COPY --from=php-builder /root/libgolangutil.so /root/example.so $LD_LIBRARY_PATH/
COPY php-7.3/extension/Util.php ./extension/Util.php
COPY php-7.3/test.php ./example/example.* ./
