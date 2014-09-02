# NAMSHI | PreConfig

[![Build Status](https://api.travis-ci.com/namshi/preconfig.svg?token=gpDfsZ6pMs8Vhxeyuq1K&branch=master)](https://magnum.travis-ci.com/namshi/preconfig)

In PHP handling configs even as array is not easy, when you need to reference related configs or replace strings in configs it is not straightforward.
This library will help you define configurations in clean, decoupled and smart way resulting in easy retrieval of configuration values. How? read on.

This library is a PHP port of [Namshi/Reconfig](https://github.com/namshi/reconfig) javascript library.

## Prerequisites

This library needs PHP 5.4+.

It has been tested using PHP5.4 to PHP5.6 and HHVM.

## Installation

You can install the library directly with composer:

```
"namshi/preconfig": "0.1.0"
```
## Usage

A simple example is given below:

### Access a multi-dimensional array

```php
namespace Your\Namespace

use Namshi\PreConfig\PreConfig;

public function foo()
{
    $argument = [
                'key1' => [
                    'key2' => '{{ key1.key3 }}',
                    'key3' => [
                        'key4' => 'value4',
                        'key5' => 'value5'
                    ]
                ]
            ];

    $preConfig = new PreConfig($argument);

    $key3 = $preConfig->get('key1.key3');
}

```

You can see more examples in the [example](src/Namshi/PreConfig/Example/example.php) file.

## Tests

We used [phpspec](http://www.phpspec.net) to write tests. They are more like specs than just tests.
You will need [composer](https://getcomposer.org) to get the dependencies, to run tests locally, execute the following commands:


```shell

 ᐅ composer install --dev --prefer-source
 ᐅ php vendor/bin/phpspec run

```

## Feedback

Add an issue, open a PR, drop us an email! We would love to hear from you!
