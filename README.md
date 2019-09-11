# Pith Framework
Website: http://pith-framework.org/

Another framework for PHP

# :warning: **(Not ready yet)** :warning:

This is a rewrite of an old framework I was working on in 2009-2010. I just stated the rewrite, so there isn't much here yet. This probably isn't what you're looking for right now, but check back later!


Release status | sv | rv | Can I use?
-------------- | -- | -- | ----------
Rewrite Pre-Alpha 5   | sv 0.6.0 | rv 0.6.2.0 | :warning: *Not yet*
Rewrite Pre-Alpha 4   | sv 0.5.0 | rv 0.6.1.0 | :warning: *Not yet*
Rewrite Pre-Alpha 3   | sv 0.4.0 | rv 0.6.0.3 | :warning: *Not yet*
Rewrite Pre-Alpha 2   | sv 0.3.0 | rv 0.6.0.2 | :warning: *Not yet*
Rewrite Pre-Alpha 1   | sv 0.2.0 | rv 0.6.0.1 | :warning: *Not yet*
(2nd) Initial Rewrite | sv 0.1.0 | rv 0.6.0.0 | :warning: *Not yet*

See http://pith-framework.org/versions for more info.



# TODO:

- [x] <del>App Object</del> :wrench:
- [x] <del>Container (Maybe use [PHP-DI](https://github.com/PHP-DI/PHP-DI)?)</del>
- [x] <del>Logger (Use [Monolog](https://github.com/Seldaek/monolog))</del>
- [x] <del>Config Object</del> :wrench:
- [ ] Registry Object
- [ ] Authenticator Object
- [ ] Access Control Object
- [x] Router Object :wrench:
- [ ] Dispatcher Object :wrench:
- [ ] Modules :wrench:
- [ ] Routes :wrench:
- [ ] Access Levels
- [ ] Injectors :wrench:
- [ ] Actions :wrench:
- [ ] Preparers :wrench:
- [ ] Views


---

# Install to your project (NOT READY YET):

### :warning: **(Not ready yet)** :warning:
- Open the terminal and navigate to the directory your project is in / will be in.
- If Composer is not installed, Install Composer into the same directory, see links for [installing Composer normally](https://getcomposer.org/download/), or more options/info on Composer's [Getting Started](https://getcomposer.org/doc/00-intro.md) page.
- If you do not have a composer.json file, create a new composer.json file in the same directory.
- Add Pith to the required section of composer.json, i.e. ```{
    "require": {
        "pith/framework": "^0.6"
    }
}```
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
- Navigate to example/public: i.e. ```
$ cd example
$ ls
$ cd public
$ ls```
- Run the test web app with the built-in PHP server: i.e. `$ php -S 127.0.0.1:9000`
- Load `http://127.0.0.1:9000/` in your browser.
- You can end the built-in PHP server by pressing `Control-C` on the keyboard.

### Problems & solutions:

**Autoloading not found**
- *Problem:* `Warning: require(vendor/autoload.php): failed to open stream: No such file or directory`
- *What's happening:* Autoloading isn't there, Composer isn't installed correctly for the project.
- *Fix:* Install or re-install composer to the directory, then run:  `$ php composer.phar install`
