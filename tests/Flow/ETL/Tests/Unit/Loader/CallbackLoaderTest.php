<?php

declare(strict_types=1);

namespace Flow\ETL\Tests\Unit\Loader;

use Flow\ETL\Loader\CallbackLoader;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry\IntegerEntry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Rows;
use PHPUnit\Framework\TestCase;

final class CallbackLoaderTest extends TestCase
{
    public function test_callback_loader() : void
    {
        $rows = new Rows(
            Row::create(new IntegerEntry('number', 1), new StringEntry('name', 'one')),
            Row::create(new IntegerEntry('number', 2), new StringEntry('name', 'two')),
        );

        $data = [];

        (new CallbackLoader(function (Rows $rows) use (&$data) : void {
            $data = $rows->toArray();
        }))->load($rows);

        $this->assertEquals($rows->toArray(), $data);
    }
}
