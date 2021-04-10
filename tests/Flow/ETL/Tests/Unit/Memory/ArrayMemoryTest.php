<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Unit\Memory;

use Flow\ETL\Memory\ArrayMemory;
use PHPUnit\Framework\TestCase;

final class ArrayMemoryTest extends TestCase
{
    public function test_map() : void
    {
        $memory = new ArrayMemory([['id' => 1], ['id' => 2]]);

        $this->assertSame([1, 2], $memory->map(fn (array $data) : int => $data['id'])->dump());
    }
}
