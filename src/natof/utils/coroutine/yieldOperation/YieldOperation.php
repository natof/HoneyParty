<?php

namespace natof\utils\coroutine\yieldOperation;

abstract class YieldOperation
{
    abstract public function moveNext(): bool;

    public function reset()
    {

    }

    public function current()
    {
        return null;
    }
}
