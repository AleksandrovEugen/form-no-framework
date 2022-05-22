#!/bin/bash

SCRIPTS_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "${SCRIPTS_DIR}/dc.sh"

# stops containers and removes containers, networks, volumes, and images created by up
${DC} down -v
