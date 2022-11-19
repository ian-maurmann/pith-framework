# Pith Framework

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/pith/framework?logo=php&style=for-the-badge)
![GitHub](https://img.shields.io/github/license/ian-maurmann/pith-framework?style=for-the-badge)

[Website](https://pith-framework.org/) | [TODO list](doc/todo-index.md) | [Stats](doc/stats.md)

---


# :warning: **(Not ready yet)** :warning:

Pith Framework is a PHP web application framework, provided under the terms of the MPL 2.0 license. Pith Framework uses a design pattern similar to MVC and ADR: (Route, Action, Model, Preparer, View).

Pith Framework requires PHP 8.1 or newer, running on a LAMP environment. 

Support for Windows Server and IIS is planned. The framework currently runs on MacOS without problems although it is not "officially" supported at this time. After PHP 8 GA (Nov 26 2020), Pith Framework will upgrade to PHP 8 will after the framework's dependencies ([PHP-DI](https://github.com/PHP-DI/PHP-DI), [Monolog](https://github.com/Seldaek/monolog), [My C-Labs' PHP Enum](https://github.com/myclabs/php-enum), and [Conso](https://github.com/lotfio/conso)).

This is a rewrite of an old framework I was working on in 2008 to 2014. The framework is basically at the "Minimum Viable Product" stage now. It works for very very bare-bones MCV (without users or access control right now), and does not have any useful features yet.


For right now you'll want to pick something full-featured instead:

i.e: [Symfony](https://symfony.com/), [Laravel](https://laravel.com/), [Slim](https://www.slimframework.com/), [Cake](https://cakephp.org/) or [Zend](https://framework.zend.com/) / [Laminas](https://getlaminas.org/)

Check back later at the end of Alpha though!

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
        "pith/framework": "^0.14"
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
~~For the current test app:~~

- ~~Open the terminal and navigate to the directory the project is downloaded to.~~
- ~~Navigate to example/public: i.e.~~

```bash
$ cd example/public
```

- ~~Run the test web app with the built-in PHP server: i.e.~~ `$ php -S 127.0.0.1:8080`
- ~~Load `http://127.0.0.1:8080/` in your browser.~~
- ~~You can end the built-in PHP server by pressing `Control-C` on the keyboard.~~

# :warning: Install for for new project (Work in progress)

### :warning: **(Not ready yet)** :warning:

- Open the terminal and navigate to the directory your project will be in.
- Install Composer. Follow the instruction at [Download Composer](https://getcomposer.org/download/).
- Type `php composer.phar` to check that Composer is installed.
- Type `php composer.phar require pith/framework` to install Pith.
- After Composer downloads the packages, type `php composer.phar show` to make sure that `pith/framework` is in the list.
- Type `cp vendor/pith/framework/pith .` to copy the Pith Command Tool into the current folder.
- Type `php pith` to check that the Pith Command Tool is there.
- Type `php pith install` **(Not ready yet)** :warning:


### Problems & solutions:


(Tilte) | Problem | What's happening | Fix
------- | ------- | ---------------- | ---
**Autoloading not found** | `Warning: require(vendor/autoload.php): failed to open stream: No such file or directory` | Autoloading is not working. Composer isn't installed correctly for the project. | Install or re-install Composer to the directory. See [installing Composer](https://getcomposer.org/download/). After Composer is installed, run:  `$ php composer.phar install`


---

## Releases

![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/ian-maurmann/pith-framework?include_prereleases&label=Latest%20Release%20%28semver%29&logo=git&style=for-the-badge)
![GitHub commits since latest release (by date including pre-releases)](https://img.shields.io/github/commits-since/ian-maurmann/pith-framework/latest/indev?include_prereleases&logo=git&style=for-the-badge)

Release status | Version | Semver | Can I use?
-------------- | ------- | ------ | ----------
Alpha 33              | 0.8.0.1 | *sv 0.19.0* | Stable, limited features
Alpha 32              | 0.8.0.0 | *sv 0.18.0* | Stable, limited features
Alpha 31              | 0.7.5.0 | *sv 0.17.0* | Stable, but not production-ready
Alpha 30              | 0.7.4.0 | *sv 0.16.0* | Stable, but not production-ready
Alpha 29              | 0.7.3.0 | *sv 0.15.0* | Stable, but not production-ready
Alpha 28              | 0.7.2.0 | *sv 0.14.0* | Stable, but not production-ready
Alpha 27              | 0.7.1.1 | *sv 0.13.0* | Stable, but not production-ready
Alpha 26              | 0.7.1.0 | *sv 0.12.0* | Stable, but not production-ready
Alpha 25              | 0.7.0.2 | *sv 0.11.0* | Stable, but not production-ready
Alpha 24              | 0.7.0.1 | *sv 0.10.0* | Stable, but not production-ready
Alpha 23              | 0.7.0.0 | *sv 0.9.1*  | (MVP) Stable, but not production-ready
Rewrite UF            | 0.6.5.0 | *sv 0.9.0*  | :warning: *Testing and experimentation.*
Rewrite Pre-Alpha 8   | 0.6.4.0 | *sv 0.8.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 7   | 0.6.3.0 | *sv 0.7.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 6   | 0.6.2.1 | *sv 0.6.1*  | :warning: *Not yet*
Rewrite Pre-Alpha 5   | 0.6.2.0 | *sv 0.6.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 4   | 0.6.1.0 | *sv 0.5.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 3   | 0.6.0.3 | *sv 0.4.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 2   | 0.6.0.2 | *sv 0.3.0*  | :warning: *Not yet*
Rewrite Pre-Alpha 1   | 0.6.0.1 | *sv 0.2.0*  | :warning: *Not yet*
(2nd) Initial Rewrite | 0.6.0.0 | *sv 0.1.0*  | :warning: *Not yet*

See https://pith-framework.org/versions for more info.


---

### Release Notes:

**0.8.0.1 - Alpha 33** `(semver: v0.19.0)`
- Remove experimental folder, since everything works fine now. 
- Refactored the Config object.
- Added new Route List objects for Config.
- Cleanup.

**0.8.0.0 - Alpha 32** `(semver: v0.18.0)`
- Upgrade to PHP 8.1
- Simplified the configuration.
- Updated routing to use FastRoute now.
- Updated dispatching to use separate Action objects and Preparer objects.

**0.7.5.0 - Alpha 31** `(semver: v0.17.0)`

- Minor changes.
- Updated the copyright notices to include 2022.

**0.7.4.0 - Alpha 30** `(semver: v0.16.0)`

- Restored the old example files.
- Updated the copyright notices to include 2021.

**0.7.3.0 - Alpha 29** `(semver: v0.15.0)`

- More documentation fix-ups.
- Working on installer, with command tool: `php pith install`
- New "pith.json" file, that will store info about the app for the installer and command tool.


**0.7.2.0 - Alpha 28** `(semver: v0.14.0)`

- Documentation fix-ups.
- Getting started on example setup.
- Getting started on new CLI tool, "Pith Command Tool", using [Conso](https://github.com/lotfio/conso), that will (eventually) be able to install a empty Pith Framework site, verify installation, set site panel passwords, see site errors and activity, number of users per day, etc. from the command line.


**0.7.1.1 - Alpha 27** `(semver: v0.13.0)`

- Dependency Refactor.
- General housekeeping / code-cleanups.

**0.7.1.0 - Alpha 26** `(semver: v0.12.0)`

- Access Control.
- Access Levels.
- 'world' access level.
- extendable Query object.


**0.7.0.2 - Alpha 25** `(semver: v0.11.0)`

- Database Wrapper object using PDO.


**0.7.0.1 - Alpha 24** `(semver: v0.10.0)`

- Getting started on the Database object.
- Updated the copyright notices to include 2020.


**0.7.0.0 - Alpha 23** `(semver: v0.9.1)`


This is a rewrite of an old framework I was working on in 2008 to 2014.

The framework is basically at the "Minimum Viable Product" stage now. It works for very very bare-bones MCV (without users or access control right now), and does not have any useful features yet.


---

Thanks for reading! -- Ian M.

---
