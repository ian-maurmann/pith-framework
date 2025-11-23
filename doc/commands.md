# Quick Command List

Get the PHP version
```
php -v
```


----
### Composer

Run composer
```
php composer
```

Show list of installed packages
```
php composer show
```

Show list of outdated packages you have installed
```
php composer outdated
```

Run Composer install - Installs the packages listed in composer.json
```
php composer install
```

Run Composer update - Updates packages listed in composer.json to new versions
```
php composer update
```


### Pith

Run the Pith Command Tool (Doesn't do anything yrt)
```
php pith
```

### Mig

Run Doctrine Migrations
```
php mig
```


Show list of migrations
```
php mig migrations:list
```

To run all migrations:
``` 
php mig migrations:migrate

yes
```


To migrate down 1 migration:
``` 
php mig migrations:migrate prev

yes
```

To migrate up 1 migration:
``` 
php mig migrations:migrate next

yes
```

### Pest

Run unit tests
```
php pest
```

Get code coverage
```
php pest --coverage
```
### PhpStan


Analyse
```
php stan analyse src
````

Analyse with level
```
php stan analyse --level 0 src
````

----



# Local Env for Mac:

### MariaDB


Install MariaDB:

https://mariadb.com/kb/en/installing-mariadb-on-macos-using-homebrew/

If MariaDB isn't running yet, start it with:

```
mysql.server start
```

To look at the SQL mode:

```
mysql

MariaDB [(none)]> SELECT @@sql_mode;
```


----

# SSH Commands

To connect to a remote webserver on the command line use SSH.

Example SSH using an SSH user login:
```
ssh username@example.com
```

You can add SSH profiles to ~/.ssh/config

Example config:

```
Host example-dev
    HostName development.example.com
    User johndoe1234dev

Host example-stage
    HostName staging.example.com
    User johndoe1234staging

Host example-prod
    HostName example.com
    User johndoe1234
```

This allows you to log in like:

```
ssh example-stage
```

---

Also, it can be helpful to have a custom command to list the SSH host profiles that are inside your SSH config. 


A usable good example is this alias written by James Ridgway here: https://www.jamesridgway.co.uk/list-ssh-hosts-from-your-ssh-config/

On Linux:
```
# Aliases

# List SSH hosts from SSH config
alias ssh-hosts="grep -P \"^Host ([^*]+)$\" $HOME/.ssh/config | sed 's/Host //'"
```

On Mac:

On newer versions of Mac you'll get an error message about  `grep: invalid option -- P` with this. The workaround is to install the GNU version of `grep` from homebrew, which (as of 2024) installs as `ggrep`, leaving the Mac version of `grep` under the normal name. 


```
brew install grep
```

Add to the `~/.zshrc` file:
```
# Aliases

# List SSH hosts from SSH config
alias ssh-hosts="ggrep -P \"^Host ([^*]+)$\" $HOME/.ssh/config | sed 's/Host //'"
```

(Note the extra g in `ggrep` - As-of 2024 anyway)


This allows you to get the list of SSH hosts from config using:

```
ssh-hosts
```

To see a list of all available aliases on the system, execute the alias command, without any arguments, in the terminal:

```
alias
```

This should list `ssh-hosts`


2025 Edit: A bit-nicer looking list

```
# Aliases
# List SSH hosts from SSH config
alias ssh-hosts="echo \"\n─────── SSH Hosts ───────\"; ggrep -P \"^Host ([^*]+)$\" $HOME/.ssh/config | sed 's/Host //'; echo \"───── / SSH Hosts ───────\n\""
```


---

# Serve Commands

### serve.php

You can run serve.php from the PHP builtin server
```
php -S 127.0.0.1:8080 serve.php
```


---

# (Project setup Maybe)

On a new sever instance, below the web root, create a folder for repositories:

``` 
mkdir repositories

ls
```

In the repositories folder, create a project folder

```
ls

cd repositories

ls

mkdir pith-project-test

ls
```

Install composer in the new project's folder.

Follow the direction at https://getcomposer.org/download/ - For example it should look something like:

``` 
ls

cd pith-project-test

ls

php -v

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

ls

php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"

php composer-setup.php

ls

php -r "unlink('composer-setup.php');"

ls
```

Add a symbolic link to composer.phar

```
ln -s ./composer.phar ./composer

ls
```

Install pith framework

``` 
ls

php -v

php composer

php composer require pith/framework
```

Copy the Pith Command Tool into the directory
```
cp vendor/pith/framework/pith .
```

Copy the Migration runner into the directory
```
cp vendor/pith/framework/mig .
```

(Add env.php)

(Add tracked-constants.php)

(Add front controller)

---

For email:
- Add SPF.
- Add DKIM
- Add PTR