<?php

declare(strict_types=1);

namespace Flow\ETL\Extractor;

use Flow\ETL\Extractor;
use Flow\ETL\Memory\Memory;
use Flow\ETL\Row;
use Flow\ETL\Rows;

/**
 * @psalm-immutable
 */
final class MemoryExtractor implements Extractor
{
    private const CHUNK_SIZE = 100;

    private Memory $memory;

    private int $chunkSize;

    private string $rowEntryName;

    public function __construct(Memory $memory, int $chunkSize = self::CHUNK_SIZE, string $rowEntryName = 'row')
    {
        $this->memory = $memory;
        $this->chunkSize = $chunkSize;
        $this->rowEntryName = $rowEntryName;
    }

    public function extract() : \Generator
    {
        foreach (\array_chunk($this->memory->dump(), $this->chunkSize) as $chunk) {
            $rows = new Rows();

            /**
             * @var array<mixed> $chunkEntry
             */
            foreach ($chunk as $chunkEntry) {
                $rows = $rows->add(Row::create(new Row\Entry\ArrayEntry($this->rowEntryName, $chunkEntry)));
            }

            yield $rows;
        }
    }
}
