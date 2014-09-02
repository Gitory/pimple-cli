# PimpleCli

[![Build Status](https://travis-ci.org/Gitory/pimple-cli.svg?branch=master)](https://travis-ci.org/Gitory/pimple-cli)
[![Latest Stable Version](https://poser.pugx.org/gitory/pimple-cli/v/stable.svg)](https://packagist.org/packages/gitory/pimple-cli)
[![License](https://poser.pugx.org/gitory/pimple-cli/license.svg)](https://packagist.org/packages/gitory/pimple-cli)
[![Total Downloads](https://poser.pugx.org/gitory/pimple-cli/downloads.svg)](https://packagist.org/packages/gitory/pimple-cli)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Gitory/pimple-cli/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Gitory/pimple-cli/?branch=master)

[PimpleCli on Packagist](https://packagist.org/packages/gitory/pimple-cli)

PimpleCli is a tool that makes it easy creating command line application.

PimpleCli works with a [Pimple](http://pimple.sensiolabs.org/) container (eg: a [Silex](http://silex.sensiolabs.org) application) and a Console Application (eg: using http://symfony.com/doc/current/components/console/introduction.html). PimpleCli's role is to discover commands in the Pimple container to make them availlable the the Console Application.

Commands needs to be registered as a service with a name ending in '.command'. The command can be anything (class, callable, etc.) that the console application understand. When using the `Symfony\Component\Console\Application` command should extends `Symfony\Component\Console\Command\Command`. You can take a look at the [Console Components documentation](http://symfony.com/doc/current/components/console/introduction.html) to get started.

## Installation

Through Composer :

```json
{
    "require": {
        "gitory/pimple-cli": "~1.0"
    }
}
```

## Examples

### Silex 2

**composer.json**

```json
{
    "require": {
        "silex/silex": "~2.0@dev",
        "gitory/pimple-cli": "~1.0",
        "symfony/console": "~2.0"
    }
}

```


**GreetCommand.php**

```php
namespace Acme\DemoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('demo:greet')
            ->setDescription('Greet someone')
            ->addArgument('name', InputArgument::REQUIRED, 'Who do you want to greet?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $text = 'Hello '.$name;
        $output->writeln($text);
    }
}
```

**index.php**

```php
require_once __DIR__.'/vendor/autoload.php';
require_once 'GreetCommand.php';

$silexApp = new Silex\Application();
$silexApp->register(new Gitory\PimpleCli\ServiceCommandServiceProvider());

// add your command as services ending in '.command' in your DI
$silexApp['user.new.command'] = function () {
    return new Acme\DemoBundle\Command\GreetCommand();
};

$consoleApp = new Symfony\Component\Console\Application($silexApp);
$consoleApp->addCommands($silexApp['command.resolver']->commands());
$consoleApp->run();

```

Launch in Cli : `php index.php demo:greet John`

![command](/doc/screenshots/command.png?raw=true)
![command](/doc/screenshots/help.png?raw=true)
