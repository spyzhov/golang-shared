FROM golang:1.13 as go-builder
WORKDIR /go
ADD library/main.go main.go
RUN go build -o /go/libimgutil.so -buildmode=c-shared main.go

FROM python:3.7.6
WORKDIR /root
ENV LD_LIBRARY_PATH=/root

COPY --from=go-builder /go/libimgutil.so ./
COPY python/main.py python/icon_128.png ./
RUN python main.py
