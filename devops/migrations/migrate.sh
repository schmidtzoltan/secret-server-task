#!/bin/bash
# A short shellscript that runs any of the migration files you specify in the command line.
case $1 in
    *)
        mysql -uroot -p$MYSQL_ROOT_PASSWORD -D $MYSQL_DATABASE < /migrations/$1.sql
    ;;
esac

