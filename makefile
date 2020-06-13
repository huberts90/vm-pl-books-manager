.PHONY: start
start: ## spin up environment
		> docker/.env.local && cat .env >> docker/.env.local
		docker-compose -f docker/docker-compose.yml up

.PHONY: stop
stop: ## stop environment
		docker-compose -f docker/docker-compose.yml stop

.PHONY: tests
tests: ## run unit and functional tests
		> docker/.env.local && cat .env.test >> docker/.env.local # issue with common DB for test and DEV environment
		docker-compose -f docker/docker-compose.yml up
		docker-compose -f docker/docker-compose.yml exec php-fpm sh -lc "yes yes | bin/console doctrine:fixtures:load && ./bin/phpunit"
		docker-compose -f docker/docker-compose.yml down

.PHONY: help
help: ## display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
