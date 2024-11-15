#!/bin/bash

set -e
set -x

HERE=$(dirname $(readlink -f $0));
cd $HERE;

source .env

echo "updating instance $INSTANCE"
echo "web port: $WEB_PORT"
echo "dn port: $DB_PORT"

git pull
./docker.sh
set +e
docker exec -it do-every-$INSTANCE-php83-web bash -c "rm /tmp/__CG__*"
docker exec -it do-every-$INSTANCE-php83-web bash -c "rm -rf cache/doctrine*"
set -e
docker exec -it do-every-$INSTANCE-php83-web bash -c "php composer.phar install"
docker exec -it do-every-$INSTANCE-php83-web bash -c "./install.sh"
docker exec -it do-every-$INSTANCE-php83-web bash -c "php composer.phar dbFull"
set +e
docker exec -it do-every-$INSTANCE-php83-web bash -c "rm /tmp/__CG__*"
docker exec -it do-every-$INSTANCE-php83-web bash -c "echo '' > app.log"
docker stop do-every-$INSTANCE-php83-ofelia
docker rm do-every-$INSTANCE-php83-ofelia
set -e

echo ""
echo "done!"
echo ""

exit 0