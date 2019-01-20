Clubman installation
====================

## Download and installation


### prepare

Create your *clubman* base project directory if needed.

    mkdir clubman


### get cakephp

Retrieve CakePHP v2.x through GitHub into your *clubman* base directory

    cd clubman
    git clone -b 2.x git://github.com/cakephp/cakephp.git .

[you might want to consider removing the .git directory]

### get clubman

Retrieve this Clubman CakePHP app through GitHub

    cd clubman
    git clone git://github.com/tribbie/clubman.git ./appclubman


### get markdown plugin

    cd clubman
    git clone git://github.com/maurymmarques/markdown-cakephp.git ./appclubman/app/Plugin/Markdown

### merge clubman app into cakepphp app directory

    cd clubman
    rsync -av --remove-source-files ./appclubman/app/ ./app/
    you can now check/remove the ./appclubman directory


## Configuration

Now all files are downloaded, let's configure Clubman

### activate config files (cakephp)

First, let's activate (replace) the CakePHP configuration files with the Clubman versions.

    cd clubman/app/Config
    cp -p routes.php.clubman routes.php
    cp -p email.php.clubman email.php
    cp -p database.php.clubman database.php
    cp -p core.php.clubman core.php
    cp -p bootstrap.php.clubman bootstrap.php


### database configuration (cakephp)

Make sure you have an (empty) database (mySQL/MariaDB are tested)

    create database clubman

Initialize the database

    cd clubman/app/Config/Schema
    mysql --user=your-db-user --password --database=your-database <clubman_schema_YYYYMMDD.sql

Configure the $default connection in the database.php file

    cd clubman/app/Config
    vi database.php


### security configuration (cakephp)

Now, let's configure the CakePHP security configuration.

    cd clubman/app/Config
    vi core.php
    configure the Security.salt
    configure the Security.cipherSeed
    configure the $prefix (optional)


### activate clubman config files (clubman)

Next, let's activate the example Clubman configuration files.

    cd clubman/app/Config/clubman
    cp -p permissions-default.php permissions.php
    cp -p menuweb-default.php menuweb.php
    cp -p menuman-default.php menuman.php
    cp -p clubman-default.php clubman.php
    cp -p club-default.php club.php


### clubman configuration (clubman)

Next, configure *your* Clubman.

    cd clubman/app/Config/clubman
    vi club.php
    configure the Club shizzle
    configure the clubweb.home
    configure the clubman.home
    configure the clubmail addresses


### check/set owners and permissions

Finally, if needed, set owner and permissions.

    cd clubman
    sudo chown -R www-data:www-data .
    sudo chmod -R a+w app/tmp



Bart Seghers
