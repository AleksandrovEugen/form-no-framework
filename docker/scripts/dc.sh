#!/bin/bash

DOCKER_DIR="$1"

# shellcheck disable=SC2034
DC="docker-compose --project-directory ${DOCKER_DIR} --file ${DOCKER_DIR}/docker-compose.yml"