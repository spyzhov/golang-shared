.PHONY: php-7.3-build php-7.3-test php-7.3-bench php-7.3 php-7.4-build php-7.4-test php-7.4-bench php-7.4 python-build python-test python java-build java-test java

SP="=========="
LN=-13
FMT="${SP}%*s${SP}\n"

all: build test
build: golang-build php-7.3-build php-7.4-build python-build java-build
test: php-7.3-test php-7.4-test python-test java-test .end


golang-build:
	@printf ${FMT} ${LN} "golang: build"
	@docker build -t golang-poc-builder -f ./library/Dockerfile .

php-7.3-build-full: golang-build php-7.3-build
php-7.3-build:
	@printf ${FMT} ${LN} "php-7.3: build"
	@docker build -t php-7.3-poc -f ./php-7.3/Dockerfile .
php-7.3-test:
	@printf ${FMT} ${LN} "php-7.3: test"
	@docker run -it php-7.3-poc php test.php
php-7.3-bench:
	@printf ${FMT} ${LN} "php-7.3: bench"
	@docker run -it -v `pwd`/bench:/root/bench php-7.3-poc php bench/test.php
php-7.3: php-7.3-build-full php-7.3-test

php-7.4-build-full: golang-build php-7.4-build
php-7.4-build:
	@printf ${FMT} ${LN} "php-7.4: build"
	@docker build -t php-7.4-poc -f ./php-7.4/Dockerfile .
php-7.4-test:
	@printf ${FMT} ${LN} "php-7.4: test"
	@docker run -it php-7.4-poc php test.php
php-7.4-bench:
	@printf ${FMT} ${LN} "php-7.4: bench"
	@docker run -it -v `pwd`/bench:/root/bench php-7.4-poc php bench/test.php
php-7.4: php-7.4-build php-7.4-test

python-build-full: golang-build python-build
python-build:
	@printf ${FMT} ${LN} "python: build"
	@docker build -t python-poc -f ./python/Dockerfile .
python-test:
	@printf ${FMT} ${LN} "python: test"
	@docker run -it python-poc python main.py
python: python-build python-test

java-build-full: java-build golang-build
java-build:
	@printf ${FMT} ${LN} "java: build"
	@docker build -t java-poc -f ./java/Dockerfile .
java-test:
	@printf ${FMT} ${LN} "java: test"
	@docker run -it java-poc java Main.java
java: java-build java-test

.end:
	@echo "${SP}${SP}===${SP}"
