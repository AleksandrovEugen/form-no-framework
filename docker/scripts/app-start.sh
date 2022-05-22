#!/bin/bash

GREEN="\033[0;32m"
RESET="\033[0m"

SCRIPTS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "${SCRIPTS_DIR}/dc.sh"

# start application
# ensure that old containers are stopped
echo -e "\n${GREEN}Stopping containers${RESET}"
${DC} stop

# start application
echo -e "\n${GREEN}Starting containers${RESET}"
${DC} up -d --force-recreate --remove-orphans
