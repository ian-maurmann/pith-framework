
![Pith Framework Logo](https://github.com/ian-maurmann/pith-framework/blob/master/doc/logo/logo/pith-framework-logo-2023-250p.png?raw=true)


## Install

(To install for new web project using the Pith Framework, See: [New Project Install Guide](doc/new-project-install-guide.md))

To install for developing the framework itself:


- Open the terminal and navigate to the directory your project will be in.
- Install Composer. Follow the instruction at [Download Composer](https://getcomposer.org/download/).
- Require Pith Framework from Composer:

```
php composer.phar require pith/framework
```


**Nice to haves:**

Add a symbolic link to composer.phar
```
ln -s ./composer.phar ./composer
```


Copy the Pith Command Tool into the directory
```
cp vendor/pith/framework/pith .
```

<del>
Copy the Migration runner into the directory

```
cp vendor/pith/framework/mig .
```
</del>

Copy the Migration runner for PostgreSQL into the directory
```
cp vendor/pith/framework/migrate-postgres .
```

Make a symbolic link to Pest inside the directory
```
ln -s ./vendor/bin/pest ./pest
```

Make a symbolic link to PHPStan inside the directory
```
ln -s ./vendor/bin/phpstan ./phpstan

ln -s ./vendor/bin/phpstan ./stan
```

