Clubman installation
====================

This version of Clubman is developed as a CakePHP v2 application.  
I have tested this Clubman app with CakePHP v2.10.24.  
[CakePHP v2.x Cookbook](https://book.cakephp.org/2/en/index.html)


## Download and merge

This repo contains my Clubman application, which goes into the CakePHP `/app` directory. Because CakePHP also has stuff in the `/app` directory, I cannot `git clone` my Clubman app directly into the CakePHP `/app` directory. Therefor, this installation is accomplished by retrieving the repos separately, and then merging them using the `rsync` command.


### prepare

Create your *clubman* base project directory if needed.

    mkdir clubman


### get CakePHP

Retrieve CakePHP v2.x through GitHub into your *clubman* base directory.

    cd clubman
    git clone -b 2.x git://github.com/cakephp/cakephp.git .

[you might now want to consider removing the CakePHP .git directory]


### remove the *example* CakePHP app directory

Since our Clubman app will replace the CakePHP app directory, we no longer need the CakePHP one.  
When afraid, you could also rename the app directory in something like appOriginalCake

For the brave:

    cd clubman
    rm -rf ./app

For the not so brave:

    cd clubman
    mv ./app ./appOriginalCake


### get Clubman app

Retrieve this Clubman CakePHP app through GitHub into the *app* subdirectory.

    cd clubman
    git clone https://github.com/tribbie/clubman.git ./app


### get Markdown plugin

Retrieve the Markdown CakePHP plugin through GitHub into the *app* directory structure.
This plugin is used to show content that is saved as Markdown.

    cd clubman
    git clone git://github.com/maurymmarques/markdown-cakephp.git ./app/Plugin/Markdown


## Configuration

Now that our Clubman app has been put into the CakePHP framework, let's start configuring Clubman.


### activate CakePHP config files

First, let's activate (replace) the CakePHP configuration files with the Clubman versions.

    cd clubman/app/Config
    cp -p routes.php.clubman routes.php
    cp -p email.php.clubman email.php
    cp -p database.php.clubman database.php
    cp -p core.php.clubman core.php
    cp -p bootstrap.php.clubman bootstrap.php


### configure CakePHP security

Next, let's configure the CakePHP security configuration.

    cd clubman/app/Config
    vi core.php
    configure the *Security.salt*
    configure the *Security.cipherSeed*
    configure the *$prefix* (optional)


### configure the clubman database

Make sure you have an (empty) database (mySQL/MariaDB are tested).

    CREATE DATABASE clubmandb;

Make sure you have a database user and password and permissions.

    SHOW GRANTS FOR `clubmandbuser`@`clubmandbhost`;
    CREATE USER `clubmandbuser`@`clubmandbhost` IDENTIFIED BY 'clubmandbpassword';
    GRANT ALL PRIVILEGES ON `clubmandb`.* TO `clubmandbuser`@`clubmandbhost`;

Initialize the database.  
**WARNING: TABLES WILL BE DROP-CREATED!**

    cd clubman/app/Config/Schema
    mysql --user=clubmandbuser --password --database=clubmandb <clubman_schema_YYYYMMDD.sql

Configure the `$default` connection in the database.php file.

    cd clubman/app/Config
    vi database.php
    configure the *default* database shizzle


### activate clubman config files

Next, let's activate the example Clubman configuration files.

    cd clubman/app/Config/clubman
    cp -p permissions-default.php permissions.php
    cp -p menuweb-default.php menuweb.php
    cp -p menuman-default.php menuman.php
    cp -p clubman-default.php clubman.php
    cp -p club-default.php club.php


### clubman configuration

Next, configure *your* Clubman.

    cd clubman/app/Config/clubman
    vi club.php
    configure the *Club* shizzle
    configure the *clubweb.home*
    configure the *clubman.home*
    configure the *clubmail* addresses

Current "theme" possibilities:

- Since Bootstrap 3.x is used, it is possible to switch to a bootswatch theme both in Club.clubweb and Club.clubman
  https://bootswatch.com/3/
- In the Club.colors array, you can provide your club colors
  They are used to draw the two sets of lines.


### check/set owners and permissions

Finally, if needed, set owner and permissions.

    cd clubman
    sudo chown -R www-data:www-data .
    sudo chmod -R a+w app/tmp


Bart Seghers
