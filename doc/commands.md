# Quick Command List

Get the PHP version
```bash
php -v
```


----
### Composer

Run composer
```bash
php composer
```

Show list of installed packages
```bash
php composer show
```

Show list of outdated packages you have installed
```bash
php composer outdated
```

Run Composer install - Installs the packages listed in composer.json
```bash
php composer install
```

Run Composer update - Updates packages listed in composer.json to new versions
```bash
php composer update
```


### Pith

Run the Pith Command Tool (Doesn't do anything yrt)
```bash
php pith
```

### Mig

Run Doctrine Migrations
```bash
php mig
```


Show list of migrations
```bash
php mig migrations:list
```




### Pest

Run unit tests
```bash
php pest
```

Get code coverage
```bash
php pest --coverage
```
### PhpStan


Analyse
```bash
php stan analyse src
````

Analyse with level
```bash
php stan analyse --level 0 src
````

----



# Local Env for Mac:

### MariaDB


Install MariaDB:

https://mariadb.com/kb/en/installing-mariadb-on-macos-using-homebrew/

If MariaDB isn't running yet, start it with:

```bash
mysql.server start
```