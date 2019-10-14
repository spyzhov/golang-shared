

build-lib:
	go build -o wrapper/libimgutil.so -buildmode=c-shared library/main.go

build-swig:
	cd wrapper && \
	swig -php7 example.i && \
	gcc `php-config --includes` \
	 	-fpic -c example_wrap.c example.c && \
	gcc -v \
		-L. -limgutil \
		-shared example_wrap.o example.o \
		-o example.so

docker:
	docker build --rm --force-rm -t=tmp .