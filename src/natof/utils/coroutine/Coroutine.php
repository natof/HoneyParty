<?php

namespace natof\utils\coroutine;

use Generator;
use natof\utils\coroutine\yieldOperation\YieldOperation;

class Coroutine
{
    private $routine;
    private $currentOperation;

    public function __construct(Generator $routine)
    {
        $this->routine = $routine;
        $this->currentOperation = $routine->current();
    }

    public function moveNext(): bool
    {
        if ($this->currentOperation instanceof YieldOperation) {
            if ($this->currentOperation->moveNext()) {
                return true;
            } else {
                $this->routine->next();
                $this->currentOperation = $this->routine->current();
            }
        }

        if ($this->routine->valid()) {
            $this->currentOperation = $this->routine->current();
            return true;
        }

        return false;
    }

    public function stop()
    {
        $this->routine = null;
        $this->currentOperation = null;
    }

    public function getRoutine(): ?Generator
    {
        return $this->routine;
    }
}