FROM golang:1.13 as go-builder
WORKDIR /go
ADD library/main.go main.go
RUN go build -o /go/libimgutil.so -buildmode=c-shared main.go

FROM openjdk:11.0.5-jdk as java-builder
WORKDIR /root

RUN apt-get update && \
	apt-get install -y gcc

COPY --from=go-builder /go/libimgutil.so /go/libimgutil.h ./
COPY ./java/extension/* ./

RUN gcc -shared -fPIC -c example.c -I/usr/local/openjdk-11/include -I/usr/local/openjdk-11/include/linux && \
	ld -v -L. -limgutil -G example.o -o libexample.so

FROM openjdk:11.0.5-jdk
WORKDIR /root
ARG LD_LIBRARY_PATH=/root
ENV LD_LIBRARY_PATH=$LD_LIBRARY_PATH

COPY --from=java-builder /root/libimgutil.so /root/libexample.so $LD_LIBRARY_PATH/
COPY java/Main.java java/icon_128.png ./

RUN java Main.java
