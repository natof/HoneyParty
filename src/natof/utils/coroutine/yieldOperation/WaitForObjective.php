<?php

namespace natof\utils\coroutine\yieldOperation;

class WaitForObjective extends YieldOperation
{
    private $objective;

    public function __construct(callable $objective)
    {
        $this->objective = $objective;
    }

    public function moveNext(): bool
    {
        return !($this->objective)();
    }
}