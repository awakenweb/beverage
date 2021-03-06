This package is not maintained anymore, a fun mini project keeped as archive only
=================================================================================

Beverage
========

I know you love Grunt and Gulp when it comes to automate tedious tasks such as minifying CSS and JS, resizing images... Everybody does.

But are you allergic to NPM as I am?

Are you fed up with having to download nearly half the Internet when you just want to minify a bunch of files?

Beverage is there for you: pure PHP- and Composer-powered task runner for your projects.

As easy to use as Gulp, minus the NPM dependencies chaos. __If you know Gulp, you already master Beverage.__

Prerequisites
-------------

* PHP 5.4+
* [Composer](https://getcomposer.org/)

Install
-------

Add this to your composer.json file:
```json
{
    "require": {
        "awakenweb/beverage": "dev-master"
    }
}
```

Modules
-------
Have a look at the [Modules](MODULES.md) page

Configuration
-------------

First, create a `drinkmenu.php` file at the root of your project. You can create a boilerplate file by running the `vendor/bin/beverage beverage:init` command.

This file will contain the different tasks you will want to run.

This file must at least contain a `defaultTask()` function that will be triggered when calling the beverage command if no specific task is called.

Here is a demo `drinkmenu.php` :

```php
<?php

use Awakenweb\Beverage\Beverage;
use Awakenweb\Beverage\Modules\Css;
use Awakenweb\Beverage\Modules\Js;

function defaultTask()
{
    minifyCss();
    minifyJs();
}

function minifyCss()
{
    Beverage::files('*.css', ['css'])
            ->then(new Css())
            ->destination('build/css');
}

function minifyJs()
{
    Beverage::files('*.js', ['js'])
            ->then(new Js())
            ->destination('build/js');
}
```

_For a more complete demo file, run `vendor/bin/beverage beverage:init`_

You can now run the command by calling `vendor/bin/beverage`

Every command can be called by shorthand: `vendor/bin/beverage b:i` will have the same effect as `vendor/bin/beverage beverage:init`.

Options
-------

You can use the `--drinkmenu` option to specify where to find the drinkmenu.php file, or if you renamed it.

File Watcher
------------

You can define a file watcher to automatically run tasks on recently modified files.

You need to import the `Awakenweb\Beverage\Watcher` module in your `drinkmenu.php` and create a dedicated `watch()` task.

```php

function watch($output)
{
    (new Watcher($output))
        ->beforeTasks(new RandomListener())
        ->afterTasks(new AnotherRandomListener())
        ->watch('*.scss', ['compileScssAndMinifyCss'], ['scss'])
        ->run();
}
```

The `beforeTasks` and `afterTasks` methods allow you to register hooks that will be triggered before and after your tasks when the files are changed.

These hooks must implement the `Awakenweb\Beverage\Watcher`Listener` that only needs a `update()` method.

By allowing a $output parameter, you give the watcher a way to tell you when a task
is triggered and when it's done.

You can either launch the watcher as any other task (`vendor/bin/beverage beverage:run watch`) or with the special task dedicated to watching files: `vendor/bin/beverage beverage:watch`

Contributing
------------


__Bugs__

* If you found a bug and feel confident enough to correct it, please send a pull request with your bugfix and a unit test to identify the bug.

* If you can't correct the bug by yourself, please fill an issue on this Github repository.

__Security vulnerabilities__

* If you think you found a security vulnerability in this package, please contact Mathieu SAVELLI by email before doing anything else.

__New Features__

* __Before__ sending a Pull Request for a new feature you want to add directly to the Beverage codebase, please contact Mathieu SAVELLI by email. If the feature is found to be a good fit for Beverage, you are free to make a pull request.

* __If you like this package, the best thing you can do is to provide new awesome modules for Beverage and notify me. I'll add them to this readme.__

Contributors
------------

* Main developer: __Mathieu SAVELLI__ (_mathieu.savelli@awakenweb.fr_)


License
-------

Beverage is released under the [MIT License](http://opensource.org/licenses/MIT)
