.PHONY: php-7.3-build php-7.3-test php-7.3 php-7.4-build php-7.4-test php-7.4 python-build python-test python

all: php-7.3-build php-7.4-build python-build php-7.3-test php-7.4-test python-test

php-7.3-build:
	@echo "php-7.3: build"
	@docker build -t php-7.3-poc -f ./php-7.3/Dockerfile .
php-7.3-test:
	@echo "php-7.3: test"
	@docker run -it php-7.3-poc php test.php
php-7.3: php-7.3-build php-7.3-test

php-7.4-build:
	@echo "php-7.4: build"
	@docker build -t php-7.4-poc -f ./php-7.4/Dockerfile .
php-7.4-test:
	@echo "php-7.4: test"
	@docker run -it php-7.4-poc php test.php
php-7.4: php-7.4-build php-7.4-test

python-build:
	@echo "python: build"
	@docker build -t python-poc -f ./python/Dockerfile .
python-test:
	@echo "python: test"
	@docker run -it python-poc python main.py
python: python-build python-test
