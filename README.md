# JConsole - An useful console tools for Joomla CMS

JConsole is a cli tools extends from Joomla Console Package. It provides an interface to cteate nested commands.

Please see: https://github.com/asika32764/joomla-framework/tree/console/src/Joomla/Console

## Installation

### Git

``` bash
$ cd /your/path/to/joomla/cli
$ git init
$ git remote add origin https://github.com/asika32764/JConsole
$ git pull origin master
```

### Download

1. Download this package: https://github.com/asika32764/JConsole/archive/master.zip
2. Uncompress and copy `console` file and `jconsole` folder to your Joomla cli folder.

## Getting started

Open terminal, go to `path/of/joomla`.

Type:

``` bash
php cli/console
```

Will get a help message:

```
Joomla! Console - version: 1.0
------------------------------------------------------------

[console Help]


Usage:
  console <command> [option]


Options:

  -h | --help       Display this help message.
  -q | --quiet      Do not output any message.
  -v | --verbose    Increase the verbosity of messages.
  --no-ansi         Suppress ANSI colors on unsupported terminals.


Available commands:

  help      List all arguments and show usage & manual.

  build     Some useful tools for building system.

  sql       Example description.

  system    System control.

Welcome to Joomla! Console.
```

## Available Commands

```
  help                   List all arguments and show usage & manual.

  build                  Some useful tools for building system.
      check-constants    Check php files which do not included Joomla constants.
      gen-command        Generate a command class.
      index              Create empty index.html files in directories.

  sql                    Example description.
      backup             Backup sql.
      col                Column operation
      export             Export sql.
      import             Import a sql file.
      profile            Profiles.
      restore            Restore to pervious point.
      table              Model operation.

  system                 System control.
      clean-cache        Clean system cache.
      off                Set this site offline.
      on                 Set this site online.

```

## Add your own Commands

### Use Plugin

Create a plugin in `console` group.

``` php
<?php

// no direct access
defined('_JEXEC') or die;

class plgConsoleMycommand extends JPlugin
{
	/**
     * onConsoleLoadCommand Event, called when auto added command.
     *
     * @param   string                     $context  The command class, example: 'Command\\Build\\Indexmaker'.
     * @param   JConsole\Command\JCommand  $command  The parent command, You can addArgument to it.
     *
     * @return  void
     */
    public function onConsoleLoadCommand($context, $command)
    {
        if ($context != 'Command\\System\\System')
        {
            return;
        }

        /** @var $command JCommand */
        $command->addArgument(
            'mycommand',             // Command name
            'This is my command.',   // Description
            null,                    // Options

            // Executing code.
            function($command)
            {
                $command->out('Hello World');
            }
        );
    }
}
```

Now, this custom command will added to system command.

```
Joomla! Console - version: 1.0
------------------------------------------------------------

[system Help]

System control.

Usage:
  system <command> [option]

Options:
  -h | --help       Display this help message.
  -q | --quiet      Do not output any message.
  -v | --verbose    Increase the verbosity of messages.
  --no-ansi         Suppress ANSI colors on unsupported terminals.

Available commands:
  mycommand      This is my command.    <---- Here is your command
  clean-cache    Clean system cache.
  off            Set this site offline.
  on             Set this site online.
```

We execute it.

``` bash
$ php cli/console system mycommand
```

Result

```
$ php console system mycommand
Hello World
```

## Use custom Command

We can put our commands in plugin folder:

```
plugins/system/mycomnand
    |---  Command
    |        |--- MyCommand
    |                |--- MyCommand.php  <--- Here is our command class
    |
    |---  mycommand.php
    |---  mycommand.xml
```

Create your command class.

``` php
<?php
namespace Command\Mycommand;

use JConsole\Command\JCommand;

class Mycommand extends JCommand
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	protected $name = 'mycommand';

	protected $description = 'This is mycommand.';

	protected function doExecute()
	{
		$this->out('Hello World.');

		return;
	}
}
```

Register command your plugin.

``` php
public function onConsoleLoadCommand($context, $command)
{
    if ($context != 'Command\\System\\System')
    {
        return;
    }

    // Add autoload to plugin folder
    JLoader::registerNamespace('Command', __DIR__);

    // Namespace 'Command\Mycommand\Mycommand` will auto match `Command/Mycommand/Mycommand.php` path.
    $command->addArgument(new Command\Mycommand\MyCommand);
}
```

This reault will same as previous section.

