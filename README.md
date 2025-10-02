# do-every
do these tasks in an interval

define tasks
add workers

track tasks for human cron workers

# README

clone repository
copy .env.dist to .env
adjust .env file
run docker.sh -> generates docker-compose.yml 
run docker compose up -d 

starts webserver, database mariadb server, ofelia cron job container
by default, no propagation, bound to 127.0.0.1

docker exec -it do-every-** bash
mycli -uroot -proot -hmysql -P3306 
create database do_every
cp configs/doctrine/docker.php doctrineConfiguration.php -> adjust if needed
./composer.phar dbFull
php scripts/init.php

touch app.log && chmod 777 app.log

./install.sh

open browser localhost:11000

first user: do-every@kwatsh.de, Passwort

in index.php
\DoEveryApp\Util\QueryLogger::$disabled = false; 
-> get insights

## 
mark initial migration executed:
./vendor/bin/doctrine-migrations migrations:version -n --add DoctrineMigrations\\Version20250926134222