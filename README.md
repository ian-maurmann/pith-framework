# Pith Framework

Website: https://pith-framework.org/


# :warning: **(Not ready yet)** :warning:

This is a rewrite of an old framework I was working on in 2008 to 2014. <del>I just stated the rewrite, so there isn't much here yet. This probably isn't what you're looking for right now, but check back later!</del>

The framework is basically at the "Minimum Viable Product" stage now. It works for very very bare-bones MCV (without users or access control right now), and does not have any useful features yet.


For right now you'll want to pick something full-featured instead:

i.e: [Symfony](https://symfony.com/), [Laravel](https://laravel.com/), [Slim](https://www.slimframework.com/), [Cake](https://cakephp.org/) or [Zend](https://framework.zend.com/) / [Laminas](https://getlaminas.org/)

Check back later at the end of Alpha though!

---

# Pith Framework
Website: https://pith-framework.org/

# TODO:

See the [TODO list](doc/todo-index.md)

---


# Install to your project (NOT READY YET):

### :warning: **(Not ready yet)** :warning:

- Open the terminal and navigate to the directory your project is in / will be in.
- If Composer is not installed, Install Composer into the same directory, see links for [installing Composer normally](https://getcomposer.org/download/), or more options/info on Composer's [Getting Started](https://getcomposer.org/doc/00-intro.md) page.
- If you do not have a composer.json file, create a new composer.json file in the same directory.
- Add Pith to the required section of composer.json, i.e.

```json
{
    "require": {
        "pith/framework": "^0.6"
    }
}
```

- Run `$ php composer.phar install`

### :warning: **(Not ready yet)** :warning:

---

# :warning: Install for testing:

### Install from the Repo:

- Pull the Git repo into desired directory.
- Install Composer into the same directory, see links for [installing Composer normally](https://getcomposer.org/download/), or more options/info on Composer's [Getting Started](https://getcomposer.org/doc/00-intro.md) page.
- Run `$ php composer.phar install`.

### Run:
For the current test app:

- Open the terminal and navigate to the directory the project is downloaded to.
- Navigate to example/public: i.e.

```bash
$ cd example
$ ls
$ cd public
$ ls
```

- Run the test web app with the built-in PHP server: i.e. `$ php -S 127.0.0.1:9000`
- Load `http://127.0.0.1:9000/` in your browser.
- You can end the built-in PHP server by pressing `Control-C` on the keyboard.

### Problems & solutions:

**Autoloading not found**
- *Problem:* `Warning: require(vendor/autoload.php): failed to open stream: No such file or directory`
- *What's happening:* Autoloading isn't there, Composer isn't installed correctly for the project.
- *Fix:* Install or re-install composer to the directory, then run:  `$ php composer.phar install`


---


Release status | Version | Semver | Can I use?
-------------- | ------- | ------ | ----------
Alpha 26              | rv 0.7.1.0 | *sv 0.12.0* | Stable, but not production-ready
Alpha 25              | rv 0.7.0.2 | *sv 0.11.0* | Stable, but not production-ready
Alpha 24              | rv 0.7.0.1 | *sv 0.10.0* | Stable, but not production-ready
Alpha 23              | rv 0.7.0.0 | *sv 0.9.1*  | (MVP) Stable, but not production-ready
Rewrite UF            | rv 0.6.5.0 | *sv 0.9.0*  | :warning: *Only use for testing and experimentation. Not for production*
Rewrite Pre-Alpha 8   | rv 0.6.4.0 | *sv 0.8.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 7   | rv 0.6.3.0 | *sv 0.7.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 6   | rv 0.6.2.1 | *sv 0.6.1*  | :warning: *Not yet*
Rewrite Pre-Alpha 5   | rv 0.6.2.0 | *sv 0.6.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 4   | rv 0.6.1.0 | *sv 0.5.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 3   | rv 0.6.0.3 | *sv 0.4.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 2   | rv 0.6.0.2 | *sv 0.3.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 1   | rv 0.6.0.1 | *sv 0.2.0*  | :warning: *Not yet*
(2nd) Initial Rewrite | rv 0.6.0.0 | *sv 0.1.0*  | :warning: *Not yet*

See https://pith-framework.org/versions for more info.


---

### Release Notes:

**0.7.1.0 - Alpha 26** *(Semver: 0.12.0)*

- Access Control.
- Access Levels.
- 'world' access level.
- extendable Query object.


**0.7.0.2 - Alpha 25** *(Semver: 0.11.0)*

- Database Wrapper object using PDO.


**0.7.0.1 - Alpha 24** *(Semver: 0.10.0)*

- Getting started on the Database object. 
- Updated the copyright notices to include 2020.


**0.7.0.0 - Alpha 23** *(Semver: 0.9.1)*


This is a rewrite of an old framework I was working on in 2008 to 2014.

The framework is basically at the "Minimum Viable Product" stage now. It works for very very bare-bones MCV (without users or access control right now), and does not have any useful features yet.


---

Thanks for reading! -- Ian M.

---
