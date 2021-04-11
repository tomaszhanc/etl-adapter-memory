<?php

declare(strict_types=1);

namespace Flow\ETL\Memory;

interface Memory
{
    /**
     * @param array<array<mixed>> $data
     */
    public function save(array $data) : void;

    /**
     * @psalm-mutation-free
     *
     * @return array<mixed>
     */
    public function dump() : array;

    /**
     * @param callable(array<mixed>) : mixed $callback
     *
     * @return array<mixed>
     */
    public function map(callable $callback) : array;
}
