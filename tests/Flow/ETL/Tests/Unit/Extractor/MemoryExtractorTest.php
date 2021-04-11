<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Unit\Extractor;

use Flow\ETL\Extractor\MemoryExtractor;
use Flow\ETL\Loader\MemoryLoader;
use Flow\ETL\Memory\ArrayMemory;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry\IntegerEntry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Rows;
use PHPUnit\Framework\TestCase;

final class MemoryExtractorTest extends TestCase
{
    public function test_memory_extractor() : void
    {
        $rows = new Rows(
            Row::create(new IntegerEntry('number', 1), new StringEntry('name', 'one')),
            Row::create(new IntegerEntry('number', 2), new StringEntry('name', 'two')),
            Row::create(new IntegerEntry('number', 3), new StringEntry('name', 'tree')),
            Row::create(new IntegerEntry('number', 4), new StringEntry('name', 'four')),
            Row::create(new IntegerEntry('number', 5), new StringEntry('name', 'five')),
        );

        $memory = new ArrayMemory();

        (new MemoryLoader($memory))->load($rows);

        $extractor = new MemoryExtractor($memory, 2);

        $data = [];

        foreach ($extractor->extract() as $rowsData) {
            $data  = \array_merge($data, $rowsData->toArray());
        }

        $this->assertSame(
            [
                ['row' => ['number' => 1, 'name' => 'one']],
                ['row' => ['number' => 2, 'name' => 'two']],
                ['row' => ['number' => 3, 'name' => 'tree']],
                ['row' => ['number' => 4, 'name' => 'four']],
                ['row' => ['number' => 5, 'name' => 'five']],
            ],
            $data
        );
    }
}
