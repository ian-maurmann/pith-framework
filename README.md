# Pith Framework

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/pith/framework?logo=php&style=for-the-badge)
![GitHub](https://img.shields.io/github/license/ian-maurmann/pith-framework?style=for-the-badge)

---

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
        "pith/framework": "^0.13"
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

- Run the test web app with the built-in PHP server: i.e. `$ php -S 127.0.0.1:8080`
- Load `http://127.0.0.1:8080/` in your browser.
- You can end the built-in PHP server by pressing `Control-C` on the keyboard.

### Problems & solutions:

**Autoloading not found**
- *Problem:* `Warning: require(vendor/autoload.php): failed to open stream: No such file or directory`
- *What's happening:* Autoloading isn't there, Composer isn't installed correctly for the project.
- *Fix:* Install or re-install composer to the directory, then run:  `$ php composer.phar install`


---

##Releases

![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/ian-maurmann/pith-framework?include_prereleases&label=Latest%20Release%20%28semver%29&logo=git&style=for-the-badge)
![GitHub commits since latest release (by date including pre-releases)](https://img.shields.io/github/commits-since/ian-maurmann/pith-framework/latest/indev?include_prereleases&logo=git&style=for-the-badge)

Release status | Version | Semver | Can I use?
-------------- | ------- | ------ | ----------
Alpha 27              | rv 0.7.1.1 | *sv 0.13.0* | Stable, but not production-ready
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

**0.7.1.1 - Alpha 27** (`semver: 0.13.0`)

- Dependency Refactor.
- General housekeeping / code-cleanups.

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
### Stats:


PHP Version Support

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/pith/framework?logo=php&style=for-the-badge)


Current Release:

![GitHub release (latest by date including pre-releases)](https://img.shields.io/github/v/release/ian-maurmann/pith-framework?include_prereleases&label=Latest%20Release%20%28semver%29&logo=git&style=for-the-badge)
![Packagist Version (including pre-releases)](https://img.shields.io/packagist/v/pith/framework?include_prereleases&label=Default%20version%20in%20Composer&logo=composer&style=for-the-badge)


License:

![Packagist License](https://img.shields.io/packagist/l/pith/framework?logo=composer&style=for-the-badge)
![GitHub](https://img.shields.io/github/license/ian-maurmann/pith-framework?logo=github&style=for-the-badge)


Size:

![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/ian-maurmann/pith-framework?logo=php&style=for-the-badge)
![GitHub repo size](https://img.shields.io/github/repo-size/ian-maurmann/pith-framework?logo=github&style=for-the-badge)


Downloads:

![Packagist Downloads](https://img.shields.io/packagist/dt/pith/framework?label=Composer%20Downloads&logo=composer&style=for-the-badge)
![GitHub All Releases](https://img.shields.io/github/downloads/ian-maurmann/pith-framework/total?label=GitHub%20Downloads&logo=github&style=for-the-badge)
![SourceForge](https://img.shields.io/sourceforge/dt/pithframework?label=SourceForge%20Downloads&logo=sourceforge&style=for-the-badge)


Activity:

![GitHub contributors](https://img.shields.io/github/contributors/ian-maurmann/pith-framework?logo=github&style=for-the-badge)
![GitHub commit activity](https://img.shields.io/github/commit-activity/w/ian-maurmann/pith-framework?logo=github&style=for-the-badge)
![GitHub (Pre-)Release Date](https://img.shields.io/github/release-date-pre/ian-maurmann/pith-framework?label=Last%20Release%20Date&logo=github&style=for-the-badge)
![GitHub commits since latest release (by date including pre-releases)](https://img.shields.io/github/commits-since/ian-maurmann/pith-framework/latest/indev?include_prereleases&logo=git&style=for-the-badge)
![GitHub pull requests](https://img.shields.io/github/issues-pr-raw/ian-maurmann/pith-framework?logo=git&style=for-the-badge)


Issues:

![GitHub issues](https://img.shields.io/github/issues-raw/ian-maurmann/pith-framework?logo=github&style=for-the-badge)
![GitHub issues by-label](https://img.shields.io/github/issues-raw/ian-maurmann/pith-framework/Planned%20Feature?color=green&logo=github&style=for-the-badge)
![GitHub issues by-label](https://img.shields.io/github/issues-raw/ian-maurmann/pith-framework/Bug?logo=github&style=for-the-badge)
![GitHub closed issues](https://img.shields.io/github/issues-closed-raw/ian-maurmann/pith-framework?logo=github&style=for-the-badge)


Misc.

![Packagist Stars](https://img.shields.io/packagist/stars/pith/framework?label=Packagist%20Stars&logo=composer&style=for-the-badge)
![Website](https://img.shields.io/website?style=for-the-badge&url=https%3A%2F%2Fpith-framework.org)

---
