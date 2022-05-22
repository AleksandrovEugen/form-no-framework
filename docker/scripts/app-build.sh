#!/bin/bash

GREEN="\033[0;32m"
RESET="\033[0m"

SCRIPTS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "${SCRIPTS_DIR}/dc.sh"

# ensure that old containers are removed
echo -e "\n${GREEN}Stopping containers${RESET}"
${DC} stop
echo -e "\n${GREEN}Removing containers${RESET}"
${DC} rm -f

# build application
echo -e "\n${GREEN}Building images${RESET}"
${DC} build --pull
