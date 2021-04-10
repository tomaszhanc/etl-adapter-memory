<?php

declare(strict_types=1);

namespace Flow\ETL\Memory;

final class ArrayMemory implements Memory
{
    /**
     * @var array<mixed>
     */
    public array $data;

    /**
     * @param array<mixed> $memory
     */
    public function __construct(array $memory = [])
    {
        $this->data = $memory;
    }

    public function save(array $data) : void
    {
        $this->data = $data;
    }

    public function dump() : array
    {
        return $this->data;
    }

    /**
     * @param callable(mixed) : mixed $callback
     */
    public function map(callable $callback) : self
    {
        return new self(\array_map($callback, $this->data));
    }
}
