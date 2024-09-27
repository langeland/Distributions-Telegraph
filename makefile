#!make

# MAIN COMMAND TARGETS
# =============================================================================
# These commands affect the application as a whole, across multiple containers
# and subsystems.
# It should be easy to use these to execute the main day-to-day operations
# required during development.

help: ## Show list of commands.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

#build: ## Start the application stack
#	docker compose build

start: ## Start the application stack
	docker compose up -d
	docker compose exec application composer install
	docker compose logs -f application

stop: ## Stops the application stack and remove containers
	docker compose down

clean: ## Stops the application stack and remove containers and Volume data
	docker compose down
	rm -fR .docker_volumes
	rm -fR Data/Logs
	rm -fR Data/Temporary
	rm -fR Packages
	rm -fR Web
	rm -fR bin
	rm -fR flow
	rm -fR flow.bat

app-bash: ## Open application bash
	docker compose exec application bash

app-warmup: ## Open application bash
	#docker compose exec application ./flow flow:core:setfilepermissions root www-data www-data
	docker compose exec application ./flow flow:cache:flush
	#docker compose exec application ./flow cache:setupall
	docker compose exec application ./flow cache:warmup
	docker compose exec application ./flow doctrine:update
	docker compose exec application ./flow resource:publish

config: ## Load config
	-rm docker-compose.yaml
	ln -s .docker/docker-compose.$(context).yaml docker-compose.yaml
