.PHONY: php-7.3 php-7.4

php-7.3:
	@docker build -t php-7.3 ./php-7.3
	@docker run -it php-7.3 php test.php

php-7.4:
	@docker build -t php-7.4 ./php-7.4
	@docker run -it php-7.4 php test.php