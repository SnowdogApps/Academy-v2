#!/usr/bin/env bash

set -e

usage="./$(basename "$0") [-h] COMMAND

Options:
    -h          show this help text

Commands:
    init                                Initializes the application
    up                                  Start containers
    down                                Destroy containers
    import_db <path_to_file.sql>        Imports database dump
    import_media <path_to_file.zip>     Imports media"

script_dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

removeLockFile(){
    if [ -e "${lock_file}" ]; then
        rm -f "${lock_file}" || {
            error "Cannot remove lock file: ${lock_file}" 4
        }
    fi
}

error() {
    removeLockFile
    echo -e "\033[0;31m$1\033[0m"
    exit "$2"
}

printToConsole() {
    echo -e "\033[0;32m$1\033[0m"
}

checkIfFileExist() {
    if ! [ -e "$1" ]; then
        error "$1 does not exist!" 5
    fi
}

initVars() {
    checkIfFileExist "$script_dir/.env"
    # shellcheck disable=SC2046
    export $(grep -E -v '^#' "$script_dir/.env" | xargs)
}

startContainers() {
    checkIfFileExist $compose_file
    checkIfFileExist $compose_file_dev
    printToConsole "Starting containers..."
    docker-compose -f "${compose_file}" -f "${compose_file_dev}" up -d --build || {
        error "Could not start containers" 6
    }
    printToConsole "Done!"
}

destroyContainers() {
    checkIfFileExist $compose_file
    checkIfFileExist $compose_file_dev
    printToConsole "Destroying containers..."
    docker-compose -f "${compose_file}" -f "${compose_file_dev}" down || {
        error "Could not destroy containers" 7
    }
    printToConsole "Done!"
}

createVolumes() {
    if [ ! -d "${script_dir}/mysql/data" ]; then
        mkdir -p "$script_dir"/mysql/data
    fi

    if [ ! -d "${script_dir}/elasticsearch/data" ]; then
        mkdir -p "$script_dir"/elasticsearch/data
    fi

    if [ ! -d "$project_dir" ]; then
        sudo mkdir "$project_dir"
    fi

    docker volume create --opt type=none --opt device="${project_dir}" --opt o=bind --name "$COMPOSE_PROJECT_NAME" > /dev/null
    docker volume create --opt type=none --opt device="${script_dir}/mysql/data" --opt o=bind --name "${COMPOSE_PROJECT_NAME}_mysql" > /dev/null
    docker volume create --opt type=none --opt device="${script_dir}/elasticsearch/data" --opt o=bind --name "${COMPOSE_PROJECT_NAME}_elasticsearch" > /dev/null
}

setupProject() {
    docker exec -it "$COMPOSE_PROJECT_NAME"_php_1 ash -c "composer install ;
    bin/magento setup:install --base-url=http://$COMPOSE_PROJECT_NAME.test/ --db-host=$MYSQL_HOST --db-name=$MYSQL_DATABASE --db-user=$MYSQL_USER --db-password=$MYSQL_PASSWORD --backend-frontname=admin --admin-firstname=admin --admin-lastname=admin --admin-email=admin@admin.com --admin-user=admin --admin-password=password123 --language=pl_PL --currency=USD --timezone=America/Chicago --use-rewrites=1 --elasticsearch-host=$ELASTICSEARCH_HOST --elasticsearch-port=$ELASTICSEARCH_PORT --elasticsearch-enable-auth=false ;
    php bin/magento setup:di:compile"
}

importDatabase() {
    until docker exec "${COMPOSE_PROJECT_NAME}_mysql_1" sh -c 'export MYSQL_PWD=$MYSQL_ROOT_PASSWORD; mysql -u root -e ";"'
    do
        echo "--Waiting for MySQL connection..."
        sleep 3
    done
    printToConsole "Importing $1"
    docker exec -i "${COMPOSE_PROJECT_NAME}_mysql_1" mysql -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE" < "$1"
    printToConsole "Done!"
}

upgradeDb() {
    docker exec -i "${COMPOSE_PROJECT_NAME}_php_1" sh -c 'bin/magento cache:clean ;
    bin/magento setup:upgrade ;
    bin/magento indexer:reindex catalogsearch_fulltext'
}

importMedia() {
    printToConsole "Importing media"
    unzip -q "$1"
    rm -rf ${project_dir}/pub/media/*
    mv media/* ${project_dir}/pub/media/
    rm -rf media
    printToConsole "Done!"
}

trap removeLockFile SIGINT

initVars || {
    error "Error while reading from .env file" 9
}

project_dir="${script_dir}/.."
compose_file="$script_dir/docker-compose.yml"
compose_file_dev="$script_dir/docker-compose-dev.yml"

lock_file="$COMPOSE_PROJECT_NAME-lock-file"

if [ -e "${lock_file}" ]; then
    error "Another instance of the script is already running" 1
fi

touch "${lock_file}" || {
    error "Cannot create lock file - exiting" 2
}

if ! [ -x "$(command -v docker-compose)" ]; then
    error "Docker-compose is not installed - exiting" 3
fi

if [ ! -f "${script_dir}/php/conf.d/custom.ini" ]; then
    touch "${script_dir}/php/conf.d/custom.ini"
fi

if [[ $1 == "init" ]]; then
    createVolumes || {
        error "Error during creating docker volumes" 10
    }
    startContainers || {
        error "Error during starting containers" 11
    }
    importDatabase "$script_dir/dump.sql" || {
        error "Error during db import" 12
    }
    setupProject || {
        error "Error during setting up the project" 14
    }
    upgradeDb || {
        error "Error during upgrading the database" 15
    }
    importMedia "$script_dir/media.zip" || {
        error "Error during media import" 16
    }
elif [[ $1 == "up" ]]; then
    startContainers || {
        error "Error during starting containers" 11
    }
elif [[ $1 == "down" ]]; then
    destroyContainers || {
        error "Error during destroying containers" 13
    }
elif [[ $1 == "import_db" && $# -eq 2 ]]; then
    importDatabase "$2" || {
        error "Error during db import" 14
    }
    upgradeDb || {
        error "Error during upgrading the database" 15
    }
elif [[ $1 == "import_media" && $# -eq 2 ]]; then
    importMedia "$2" || {
        error "Error during media import" 16
    }
else
    echo "$usage"
fi

removeLockFile
