FROM openjdk:11.0.5-jdk as java-builder
WORKDIR /root

RUN apt-get update && \
	apt-get install -y gcc

# From: library/Dockerfile
COPY --from=golang-poc-builder /go/libgolangutil.so /go/libgolangutil.h ./
COPY ./java/extension/* ./

RUN gcc -shared -fPIC -c example.c -I/usr/local/openjdk-11/include -I/usr/local/openjdk-11/include/linux && \
	ld -v -L. -lgolangutil -G example.o -o libexample.so

FROM openjdk:11.0.5-jdk
WORKDIR /root
ARG LD_LIBRARY_PATH=/root
ENV LD_LIBRARY_PATH=$LD_LIBRARY_PATH

COPY --from=java-builder /root/libgolangutil.so /root/libexample.so $LD_LIBRARY_PATH/
COPY java/Main.java example/example.* ./
