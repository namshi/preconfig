# NAMSHI | PreConfig

[![Build Status](https://api.travis-ci.com/namshi/preconfig.svg?token=gpDfsZ6pMs8Vhxeyuq1K&branch=master)](https://magnum.travis-ci.com/namshi/preconfig)

In PHP handling configs even as array is not easy, when you need to reference related configs or replace strings in configs it is not straightforward.
This library will help you define configurations in clean, decoupled and smart way resulting in easy retrieval of configuration values. How? read on.

This library is a PHP port of [Namshi/Reconfig](https://github.com/namshi/reconfig) javascript library.

## Installation

Submit to packagist

Pick major and minor version according to your needs.

## Usage

You can see some [examples](src/Namshi/PreConfig/Example/example.php).


### Access a multi-dimensional array

```php
namespace Your\Namespace

use Namshi\PreConfig\PreConfig;

public function yourFunction()
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

## Tests

We used [phpspec](http://www.phpspec.net) to write tests. They are more like specs than just tests,
to run tests execute the following commands:


```shell

 ᐅ composer install --prefer-dist
 ᐅ php vendor/bin/phpspec run

```