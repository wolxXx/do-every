#!/bin/bash

set -e

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

source .env

docker compose up -d --build --force-recreate --pull always

echo "running under http://localhost:$WEB_PORT"