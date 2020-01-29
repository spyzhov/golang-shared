FROM golang:1.13 as golang-poc-builder
ENV GO111MODULE=on
ENV GOFLAGS=" -mod=vendor"
ENV GOPROXY=direct
ENV GOSUMDB=off

WORKDIR /go/src/github.com/spyzhov/golang-shared
ADD library/main.go library/go.mod library/go.sum ./
RUN go mod vendor && \
 	go build \
		-o /go/libgolangutil.so \
		-buildmode=c-shared \
			main.go
