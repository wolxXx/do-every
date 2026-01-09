#!/bin/bash

set -e

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

source .env
cp ./docker-compose.yml.dist ./docker-compose.yml
sed -i -e "s/__INSTANCE__/${INSTANCE}/g" ./docker-compose.yml
sed -i -e "s/__DB_PORT__/${DB_PORT}/g" ./docker-compose.yml
sed -i -e "s/__WEB_PORT__/${WEB_PORT}/g" ./docker-compose.yml
sed -i -e "s/__PROD_PORT__/${PROD_PORT}/g" ./docker-compose.yml

exit 0;