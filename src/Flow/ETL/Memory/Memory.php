<?php

declare(strict_types=1);

namespace Flow\ETL\Memory;

interface Memory
{
    /**
     * @param array<mixed> $data
     */
    public function save(array $data) : void;
}
