#!/bin/bash

set -e

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

source .env


required_vars=("INSTANCE" "COMPOSE_PROJECT_NAME" "DB_PORT" "WEB_PORT")
missing_vars=()

for var_name in "${required_vars[@]}"; do
    if [ -z "${!var_name}" ]; then
        missing_vars+=("$var_name")
    fi
done

if [ ${#missing_vars[@]} -ne 0 ]; then
    echo "Error: The following variables are not set in .env file: ${missing_vars[*]}"
    exit 1
fi

docker compose up -d --build --force-recreate --pull always

echo "running under http://localhost:$WEB_PORT"