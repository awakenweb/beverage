Extend Beverage
===============

Beverage is modular and is based on Symfony Console component.

You can simply extend it by creating your own custom modules and commands.


Create a new module
-------------------

Modules are used to add new tasks types to Beverage.

To add a new module, your class must implement the `Awakenweb\Beverage\Modules\Module` interface, and should therefore have a `process` method.

This method must accept an array containing the current state of the files beeing processed, and return the updated state as an array of the same format. This is the format of the array : `[file_name1 => file_content1, file_name2 => file_content2]`

```php
<?php

use Awakenweb\Beverage\Modules\Module;

class SayHello implements Module
{

    /**
     * This is a hugely useless module that creates a copy of the files it receives and renames
     * them from "filename" to "hello_filename"
     */
    public function process(array $current_state) {

        $updated_state = [];

        foreach($current_state as $filename => $file_content) {
            $updated_state['hello_'.$filename] = $file_content;
        }

        return $updated_state;

    }

}
```

Create a new command
--------------------

To add a command to the CLI tool, you have to create a new php class that extends `Symfony\Component\Console\Command\Command`.

```php
<?php

namespace Awakenweb\MyModule;

use Symfony\Component\Console\Command\Command;

class MyFabulousHelloWorldCommand extends Command {

 protected function configure()
    {
        $this
            ->setName('mymodule:hello')
            ->setDescription('Say "Hello world!" in a fabulous way!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('HeLlO wOrLd!!!!!!!!!!!!!!!!!!!!!!!!!!');
    }

}
```

To register your command to the CLI tool, you need a `register_custom_commands()` function in your `drinkmenu.php` file.

This function must return an array containing all the command class names, including their namespace.

```php
<?php //drinkmenu.php file

function register_custom_commands() {
    return ['Awakenweb\MyModule\MyFabulousHelloWorldCommand'];
}
```


Watcher hooks
-------------

The file watcher allows you to hook specific actions after and before running the tasks.

You have access to two methods : `beforeTasks()` and `afterTasks()` to specify when you want to hook your actions.

To create a hook, you must create a class that implements the `Awakenweb\Beverage\Watcher\Listener` interface and its unique method `update()`.

This method is called for every Listener before and after tasks are run.

```php

<?php

namespace Awakenweb\MyModule;

use Awakenweb\Beverage\Watcher\Listener;

class SayHelloBeforeTasksAreRun implements Listener {

    protected $output;

    public function __construct($output){

        $this->output = $output;

    }

    public function update(){
        $this->output->writeln('Hello!');
    }


}

```