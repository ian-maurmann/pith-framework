# New project guide (WIP):

## Part 0: System Reqs

This guide assumes that:
- The Webserver is a Linux Webserver. (Pith needs a Unix/BSD/Linux style of architecture, so using something like Windows Server will require extra work not covered here and need Docker or a VM, but Pith Frameworks is targeted to Linux as its main OS.)
- The Webserver is using Apache. (Nginx will need a little bit of extra work not covered here)
- The Webserver has PHP 8.4.2 or newer installed.
- The Webserver has MariaDB 11.3.2 or newer installed. (MySQL will work with other steps not covered here, but Pith Framework is targeted to MariaDB as its main database.)

## Part 1: Create a new Git Repo

Create a new empty Git repository, i.e. on GitHub, Bitbucket, or GitLab. 

Example Git repository name: `my-awesome-web-project`

## Part 2: Clone to a folder on your Local Env

Clone the new repository to a folder on your local computer or work environment. 

Example folder: `MyUsernameHere/Repositories/my-awesome-web-project`

## Part 3: Install PHP if needed


- Open the terminal, and check if PHP exists on your local setup:

``` 
php -v
```

- If PHP isn't installed, or is below 8.4.2, then install PHP 8.4.2 or newer.

Links for installing PHP

- PHP website: https://www.php.net/
- Installing PHP on Ubuntu: https://documentation.ubuntu.com/server/how-to/web-services/install-php/index.html
- Installing PHP on AlmaLinux: https://cloudspinx.com/how-to-install-php-on-rocky-linux-almalinux/
- PHP on Homebrew for MacOS https://formulae.brew.sh/formula/php
## Install Composer

- Open the terminal and navigate to the folder for your project.
- Double check again that PHP is available and working:
``` 
php -v
```
- Install Composer to your project by following the instructions at [Download Composer](https://getcomposer.org/download/).

- After installing Composer, try running it to see if it is there now:
```
php composer.phar 
```

Add a symbolic link to composer.phar to make it easier to type:
```
ln -s ./composer.phar ./composer
```

- Now Composer should also work when you just run:
```
php composer
```



## Install Pith

- Install Pith Framework to your project using Composer:

```
php composer require pith/framework
```

- To see a list of everything that Composer installed, run:

```
php composer show
```

- Copy the Pith Command Tool into the directory
```
cp vendor/pith/framework/pith .
```

- Copy the Doctrine Migrations runner into the directory
```
cp vendor/pith/framework/mig .
```

- Look at the files in the project:

```
ls 

ls -la
```

- The files should now include `composer`, `composer.json`, `composer.lock`, `composer.phar`, `mig`, `pith`, and the `vendor/` folder.

- Run pith, it will ask for a first-time setup:

```
php pith
```


- Run Composer install

```
php composer install
```

- Next run Composer update

```
php composer update
```

- To run locally, go to the `run` folder, and then the `public-local` folder
```
ls

cd run

ls

cd public-local
```

Run `serve.php` from the PHP built-in server
```
php -S 127.0.0.1:8081 serve.php
```

Now open your web browser to http://127.0.0.1:8081 , and it should be up and running.