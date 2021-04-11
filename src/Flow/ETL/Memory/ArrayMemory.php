<?php

declare(strict_types=1);

namespace Flow\ETL\Memory;

use Flow\ETL\Exception\InvalidArgumentException;

final class ArrayMemory implements Memory
{
    /**
     * @var array<array<mixed>>
     */
    public array $data;

    /**
     * @param array<array<mixed>> $memory
     */
    public function __construct(array $memory = [])
    {
        $this->assertMemoryStructure($memory);

        $this->data = $memory;
    }

    /**
     * @param array<array<mixed>> $data
     */
    public function save(array $data) : void
    {
        $this->assertMemoryStructure($data);

        $this->data = $data;
    }

    public function dump() : array
    {
        return $this->data;
    }

    /**
     * @param callable(array<mixed>) : mixed $callback
     *
     * @return array<mixed>
     */
    public function map(callable $callback) : array
    {
        return \array_map($callback, $this->data);
    }

    /**
     * @param array<array<mixed>> $memory
     *
     * @throws InvalidArgumentException
     */
    private function assertMemoryStructure(array $memory) : void
    {
        foreach ($memory as $entry) {
            /** @psalm-suppress DocblockTypeContradiction */
            if (!\is_array($entry)) {
                throw new InvalidArgumentException('Memory expects nested array data structure: array<array<mixed>>');
            }
        }
    }
}
