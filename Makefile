.DEFAULT: help
.PHONY: build start stop down exec php node profile dump-config

RUN_ARGS=$(filter-out $@,$(MAKECMDGOALS))
DOCKER_DIR=./docker

$(shell cp -n ${DOCKER_DIR}/.env.dist ${DOCKER_DIR}/.env)
$(shell cp -n .env.example .env)
$(shell cp -n ${DOCKER_DIR}/image/mysql/docker-entrypoint-initdb.d/createdb.sql.dist ${DOCKER_DIR}/image/mysql/docker-entrypoint-initdb.d/createdb.sql)

include ${DOCKER_DIR}/.env

DC=docker-compose --project-directory ${DOCKER_DIR} --file ${DOCKER_DIR}/docker-compose.yml

help:
	@echo ''
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
	@echo ''

##Commands:
##build       Build application
build:
	@bash ${DOCKER_DIR}/scripts/app-build.sh ${DOCKER_DIR}

##start       Start application without images rebuild
start:
	@bash ${DOCKER_DIR}/scripts/app-start.sh ${DOCKER_DIR}

##stop        Stop application
stop:
	@bash ${DOCKER_DIR}/scripts/app-stop.sh ${DOCKER_DIR}

##down        Stop application and remove all data including volumes
down:
	@bash ${DOCKER_DIR}/scripts/app-down.sh ${DOCKER_DIR}

##exec        Execute command in service
exec:
	@$(DC) exec $(RUN_ARGS) || true

##php         Execute php container
php:
	@$(DC) exec php bash || true

##install     Install project for local development
install: start
	@$(DC) exec php composer install

##dump-config Print config
dump-config:
	@$(DC) config

%: ; @:
