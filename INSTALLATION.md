Clubman installation
====================

## Download and installation


### prepare

create your <base> directory if needed


### get cakephp

    cd <base>
    git clone -b 2.x git://github.com/cakephp/cakephp.git .

[you might want to consider removing the .git directory]

### get clubman

    cd <base>
    git clone git://github.com/tribbie/clubman.git ./appclubman


### get markdown plugin

    cd <base>
    git clone git://github.com/maurymmarques/markdown-cakephp.git ./appclubman/app/Plugin/Markdown

### merge clubman app into cakepphp app directory

    cd <base>
    rsync -av --remove-source-files ./appclubman/app/ ./app/
    you can now check/remove the ./appclubman directory


## Configuration


### activate config files (cakephp)

    cd <base>/app/Config
    cp -p routes.php.clubman routes.php
    cp -p email.php.clubman email.php
    cp -p database.php.clubman database.php
    cp -p core.php.clubman core.php
    cp -p bootstrap.php.clubman bootstrap.php


### database configuration (cakephp)

Make sure you have an (empty) database
    create database clubman

Initialize the database
    cd <base>/app/Config/Schema
    mysql --user=your-db-user --password --database=your-database <clubman_schema.sql
    cd <base>/app/Config

Configure the $default connection in the database.php file
    vi database.php


### security configuration (cakephp)

    cd <base>/app/Config
    vi core.php
    configure the Security.salt
    configure the Security.cipherSeed
    [configure the $prefix]


### activate clubman config files (clubman)

    cd <base>/app/Config/clubman
    cp -p permissions-default.php permissions.php
    cp -p menuweb-default.php menuweb.php
    cp -p menuman-default.php menuman.php
    cp -p clubman-default.php clubman.php
    cp -p club-default.php club.php


### clubman configuration (clubman)

    cd <base>/app/Config/clubman
    vi club.php
    configure the Club shizzle
    configure the clubweb.home
    configure the clubman.home
    configure the clubmail addresses


### check/set owners and permissions

    cd <base>
    sudo chown -R www-data:www-data .
    sudo chmod -R a+w app/tmp



Bart Seghers
