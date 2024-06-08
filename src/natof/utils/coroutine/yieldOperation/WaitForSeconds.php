<?php

namespace natof\utils\coroutine\yieldOperation;

use InvalidArgumentException;

class WaitForSeconds extends YieldOperation
{
    private $endTime;

    public function __construct(float $seconds)
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException("Cannot wait for negative time");
        }
        $this->endTime = microtime(true) + $seconds;
    }

    public function moveNext(): bool
    {
        return microtime(true) < $this->endTime;
    }
}