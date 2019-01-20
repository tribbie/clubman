Clubman installation
====================

This version of Clubman is developed as a CakePHP v2 application.  
I have tested this Clubman app with CakePHP v2.9.0.


## Download and merge

This repo contains my Clubman application, which goes in the CakePHP app directory. Because CakePHP also has stuff in the app directory, I cannot git clone my Clubman app directly into the CakePHP app directory. Therefor, the installation is retrieving the repos separately, and then merges them using the `rsync` command.

### prepare

Create your *clubman* base project directory if needed.

    mkdir clubman

### get cakephp

Retrieve CakePHP v2.x through GitHub into your *clubman* base directory.

    cd clubman
    git clone -b 2.x git://github.com/cakephp/cakephp.git .

[you might want to consider removing the .git directory]

### get clubman

Retrieve this Clubman CakePHP app through GitHub into a separate *appclubman* subdirectory (for now).

    cd clubman
    git clone git://github.com/tribbie/clubman.git ./appclubman

### get markdown plugin

Retrieve the MarkDown CakePHP plugin through GitHub into the *appclubman* directory structure.

    cd clubman
    git clone git://github.com/maurymmarques/markdown-cakephp.git ./appclubman/app/Plugin/Markdown

### merge clubman app into cakepphp app directory

Now, merge the Clubman app into the CakePHP.

    cd clubman
    rsync -av --remove-source-files ./appclubman/app/ ./app/

You can now check (it should not contain files) and then remove the ./appclubman directory. It is no longer needed.


## Configuration

Now all files are downloaded, let's start configuring Clubman.

### activate config files (cakephp)

First, let's activate (replace) the CakePHP configuration files with the Clubman versions.

    cd clubman/app/Config
    cp -p routes.php.clubman routes.php
    cp -p email.php.clubman email.php
    cp -p database.php.clubman database.php
    cp -p core.php.clubman core.php
    cp -p bootstrap.php.clubman bootstrap.php


### security configuration (cakephp)

Next, let's configure the CakePHP security configuration.

    cd clubman/app/Config
    vi core.php
    configure the *Security.salt*
    configure the *Security.cipherSeed*
    configure the *$prefix* (optional)


### database configuration (cakephp)

Make sure you have an (empty) database (mySQL/MariaDB are tested).

    create database clubman

Initialize the database.  
**WARNING: TABLES WILL BE DROP-CREATED!**

    cd clubman/app/Config/Schema
    mysql --user=your-db-user --password --database=your-database <clubman_schema_YYYYMMDD.sql

Configure the $default connection in the database.php file

    cd clubman/app/Config
    vi database.php
    configure the *default* database shizzle


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
    configure the *Club* shizzle
    configure the *clubweb.home*
    configure the *clubman.home*
    configure the *clubmail* addresses


### check/set owners and permissions

Finally, if needed, set owner and permissions.

    cd clubman
    sudo chown -R www-data:www-data .
    sudo chmod -R a+w app/tmp


Bart Seghers
