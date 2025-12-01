dev:
	php -S localhost:8000 -t public

build:
	php bin/console asset-map:compile

