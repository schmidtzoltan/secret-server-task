#!/bin/bash
# Shortcuts to make my own life easier - not super fine-tuned but does the work.
case $1 in
    start)
        docker-compose up --build -d
    ;;

    enter)
        docker-compose exec $2 bash
    ;;

    inspect)
        docker-compose ps
    ;;

    stop)
        docker-compose down
    ;;

    *)
        docker-compose $*
    ;;
esac
