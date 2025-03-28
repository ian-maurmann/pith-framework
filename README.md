# Pith Framework

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/pith/framework?logo=php&style=for-the-badge)
![GitHub](https://img.shields.io/github/license/ian-maurmann/pith-framework?style=for-the-badge)

[Website](https://pith-framework.org/) | [Release Notes](doc/release-notes.md)

---

### :warning: **(Not ready yet)** :warning:

---

This framework is a work-in-progress proof-of-concept.

If you're looking for a framework to use for your project, please check out:
[Symfony](https://symfony.com/),
[Laravel](https://laravel.com/),
[Zend / Laminas](https://getlaminas.org/),
[Slim](https://www.slimframework.com/),
[Cake](https://cakephp.org/),
or [CodeIgniter](https://codeigniter.com/) instead.


---

![Pith Framework Logo](https://github.com/ian-maurmann/pith-framework/blob/master/doc/logo/logo/pith-framework-logo-2023-250p.png?raw=true)


## Install

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

Copy the Migration runner into the directory
```
cp vendor/pith/framework/mig .
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



---

### :warning: **(Not ready yet)** :warning:

---
Workflow:

![Pith workflow diagram](https://github.com/ian-maurmann/pith-framework/blob/master/doc/images/pith-workflow-diagram.png?raw=true)

.

(Actual flow)

![Pith Framework flow diagram](https://github.com/ian-maurmann/pith-framework/blob/master/doc/images/pith-framework-flow-diagram.png?raw=true)




---