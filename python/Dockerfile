FROM python:3.7.6
WORKDIR /root
ENV LD_LIBRARY_PATH=/root

# From: library/Dockerfile
COPY --from=golang-poc-builder /go/libgolangutil.so ./
COPY python/main.py example/example.* ./
