Currency converter
==================

* This application is written in symfony 4


# Requirements

* [docker](https://docs.docker.com/install/)
* [composer](https://getcomposer.org/download/)

# Framework

    Symfony 4.0

# Download

    git clone https://github.com/yakobabada/shop.git


# Installation

    cd shop/
    docker-compose up -d
    docker exec -it shop_php_1 sh
    composer install

# Run test

    bin/phpunit

# Execution

    bin/console app:convert-currency-for-orders 1=EUR 2=GBP