# NAMSHI | PreConfig

[![Build Status](https://api.travis-ci.com/namshi/preconfig.svg?token=gpDfsZ6pMs8Vhxeyuq1K&branch=master)](https://magnum.travis-ci.com/namshi/preconfig)

This library is a PHP port of [Namshi/Reconfig](https://github.com/namshi/reconfig) javascript library.

## Installation

Submit to packagist

Pick major and minor version according to your needs.

## Usage

Below are some usage examples.


### Access a multi-dimensional array

```php
namespace Your\Namespace

use Namshi\PreConfig\PreConfig;


 $argument = [
            'key1' => [
                'key2' => '{{ key1.key3 }}',
                'key3' => [
                    'key4' => 'value4',
                    'key5' => 'value5'
                ]
            ]
        ];

$preConfig = new Preconfig($argument);

$key3 = $preConfig->get('key1.key3');

```

## Tests

We used [phpspec](http://www.phpspec.net) to write tests. They are more like specs than just tests,
to run tests execute the following commands:


```shell

 ᐅ composer install --prefer-dist
 ᐅ php vendor/bin/phpspec run

```