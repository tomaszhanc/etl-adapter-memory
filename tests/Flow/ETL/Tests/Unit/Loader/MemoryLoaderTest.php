<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Unit\Loader;

use Flow\ETL\Loader\MemoryLoader;
use Flow\ETL\Memory\Memory;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry\IntegerEntry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Rows;
use PHPUnit\Framework\TestCase;

final class MemoryLoaderTest extends TestCase
{
    public function test_loads_rows_data_into_memory() : void
    {
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

        $this->assertEquals($rows->toArray(), $memory->data);
    }
}
