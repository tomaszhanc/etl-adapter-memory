# ETL Adapter: Memory

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)

## Description

ETL Adapter that provides Loaders and <s>Extractors</s> that works with Elasticsearch.

Following implementation are available:
- [elasticsearch-php](https://github.com/elastic/elasticsearch-php)


## Loader - MemoryLoader

```php 
<?php

use Flow\ETL\Loader\MemoryLoader;
use Flow\ETL\Memory\Memory;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry\IntegerEntry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Rows;

$rows = new Rows(
    Row::create(new IntegerEntry('number', 1), new StringEntry('name', 'one')),
    Row::create(new IntegerEntry('number', 2), new StringEntry('name', 'two')),
);
$memory = new class implements Memory {
    /**
     * @var array<mixed>
     */
    public array $data = [];

    public function save(array $data) : void
    {
        $this->data = $data;
    }
};

(new MemoryLoader($memory))->load($rows);
```

## Loader - CallbackLoader

```php
<?php

use Flow\ETL\Loader\CallbackLoader;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry\IntegerEntry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Rows;

$rows = new Rows(
    Row::create(new IntegerEntry('number', 1), new StringEntry('name', 'one')),
    Row::create(new IntegerEntry('number', 2), new StringEntry('name', 'two')),
);

(new CallbackLoader(function (Rows $rows) use (&$data) : void {
    $rows->each(function (Row $row) : void {
        print $row->valueOf('number') . "\n";
    });
}))->load($rows);

```

## Development

In order to install dependencies please, launch following commands:

```bash
composer install
```

## Run Tests

In order to execute full test suite, please launch following command:

```bash
cp docker-compose.yaml.dist docker-compose.yaml
docker-compose up
composer build
```

It's recommended to use [pcov](https://pecl.php.net/package/pcov) for code coverage however you can also use
xdebug by setting `XDEBUG_MODE=coverage` env variable.