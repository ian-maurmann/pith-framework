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


----

## SSH Setup

To connect to a remote webserver on the command line use SSH.

Example SSH using an SSH user login:
```bash
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

```bash
ssh example-stage
```

---

Also, it can be helpful to have a custom command to list the SSH host profiles that are inside your SSH config. 


A usable good example is this alias written by James Ridgway here: https://www.jamesridgway.co.uk/list-ssh-hosts-from-your-ssh-config/

On Linux:
```bash
# Aliases

# List SSH hosts from SSH config
alias ssh-hosts="grep -P \"^Host ([^*]+)$\" $HOME/.ssh/config | sed 's/Host //'"
```

On Mac:

On newer versions of Mac you'll get an error message about  `grep: invalid option -- P` with this. The workaround is to install the GNU version of `grep` from homebrew, which (as of 2024) installs as `ggrep`, leaving the Mac version of `grep` under the normal name. 


```bash
brew install grep
```

Add to the `~/.zshrc` file:
```bash
# Aliases

# List SSH hosts from SSH config
alias ssh-hosts="ggrep -P \"^Host ([^*]+)$\" $HOME/.ssh/config | sed 's/Host //'"
```

(Note the extra g in `ggrep` - As-of 2024 anyway)


This allows you to get the list of SSH hosts from config using:

```bash
ssh-hosts
```