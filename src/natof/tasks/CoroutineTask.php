<?php

namespace natof\tasks;

use natof\Utils\coroutine\CoroutineManager;
use pocketmine\scheduler\Task;

class CoroutineTask extends Task
{
    public function onRun(): void
    {
        CoroutineManager::OnTick();
    }
}