beverage
========

I know you love Grunt and Gulp when it comes to automate tedious tasks such as minifying CSS and JS, resizing images... Everybody does.

But are you allergic to NPM and Node.js like I am?

Are you fed up with having to download nearly half the Internet when you just want to minify a bunch of files?

Beverage is there for you: pure PHP- and Composer-powered task runner for your projects.

As easy to use as Gulp, minus the NPM dependencies hassle.

Prerequisites
-------------

* PHP 5.4+
* [Composer](https://getcomposer.org/)

Configuration
-------------

First, create a `drinkmenu.php` file at the root of your project.

This file will contain the different tasks you will want to run.

This file must at least contain a `defaultTask()` function that will be triggered when calling the beverage command if no specific task is called.

Here is a demo `drinkmenu.php` :

```php
<?php

use Awakenweb\Beverage\Beverage;

function defaultTask()
{
    minifyCss();
    minifyJs();
}

function minifyCss()
{
    Beverage::files('*.css', ['css'])
            ->then(['Awakenweb\Beverage\Modules\Css', 'process'])
            ->destination('build/css');
}

function minifyJs()
{
    Beverage::files('*.js', ['js'])
            ->then(['Awakenweb\Beverage\Modules\Js', 'process'])
            ->destination('build/js');
}

```

You can now run the command by calling `vendor/bin/beverage`

Options
-------

You can use the `--drinkmenu` option to specify where to find the drinkmenu.php file, or if you renamed it.

Create a new module
-------------------

Modules are used to add new tasks types to Beverage.

To add a new module, your class must implement the `Awakenweb\Beverage\Modules\Module` interface, and should therefore have a `process` static method.

This method must accept an array containing the current state of the files beeing processed, and return the updated state as an array of the same format. This is format : `[file_name1 => file_content1, file_name2 => file_content2]`

```php
<?php

use Awakenweb\Beverage\Modules\Module;

class SayHello implements Module
{
    
    /**
     * This is a hugely useless module that creates a copy of the files it receives and renames
     * them from "filename" to "hello_filename"
     */
    public static function process(array $current_state) {
        
        $updated_state = [];
        
        foreach($current_state as $filename => $file_content) {
            $updated_state['hello_'.$filename] = $file_content;
        }
        
        return $updated_state;
        
    }
    
}
```

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