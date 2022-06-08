#!/usr/bin/env bash
#база для тестов , которая запсиывается в локальный док , перед началом тестирования необходимо очищать док - удалять бд и создавать заново
export APP_ENV=test
echo $APP_ENV
symfony console doctrine:database:drop --force
symfony console doctrine:database:create
symfony console doctrine:schema:update --force

symfony php ./vendor/bin/phpunit --testdox --group integration
