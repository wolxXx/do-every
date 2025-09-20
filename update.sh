#!/bin/bash

set -e
set -x

# Detect docker compose command
if command -v docker-compose &> /dev/null; then
    DOCKER_COMPOSE_CMD="docker-compose"
elif command -v docker &> /dev/null && docker compose version &> /dev/null; then
    DOCKER_COMPOSE_CMD="docker compose"
else
    echo "Neither docker-compose nor docker compose is available"
    exit 1
fi

HERE=$(dirname $(readlink -f $0));
cd $HERE;

source .env

echo "updating instance $INSTANCE"
echo "web port: $WEB_PORT"
echo "dn port: $DB_PORT"

git pull
./docker.sh
set +e
docker exec -it do-every-$INSTANCE-web bash -c "rm /tmp/__CG__*"
docker exec -it do-every-$INSTANCE-web bash -c "rm -rf cache/doctrine*"
set -e
$DOCKER_COMPOSE_CMD up -d --build --force-recreate --pull always
docker exec -it do-every-$INSTANCE-web bash -c "php composer.phar install"
docker exec -it do-every-$INSTANCE-web bash -c "./install.sh"
docker exec -it do-every-$INSTANCE-web bash -c "php composer.phar dbFull"
set +e
docker exec -it do-every-$INSTANCE-web bash -c "rm /tmp/__CG__*"
docker exec -it do-every-$INSTANCE-web bash -c "echo '' > app.log"
docker stop do-every-$INSTANCE-ofelia
docker rm do-every-$INSTANCE-ofelia
set -e
$DOCKER_COMPOSE_CMD up -d --build --force-recreate --pull always

echo ""
echo "done!"
echo ""

exit 0