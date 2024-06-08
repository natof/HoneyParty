<?php

namespace natof\managers;

use Generator;
use natof\IHoneyEvent;
use natof\utils\coroutine\CoroutineManager;
use pocketmine\player\Player;

trait EventManager
{
    public $currentEvent = null;
    public string|null $currentEventState = null;

    public function registerEvent(IHoneyEvent $event): void
    {
        $this->events[$event->getName()] = $event;
    }

    public function tryStartEvent(string $eventName): bool
    {
        if ($this->eventInProgress()) {
            return false;
        }

        if (!isset($this->events[$eventName])) {
            return false;
        }

        $this->currentEvent = $this->events[$eventName];
        CoroutineManager::StartCoroutine($this->executeEvent($this->currentEvent));
        return true;
    }

    public function eventInProgress(): bool
    {
        return $this->currentEvent != null;
    }

    private function executeEvent(IHoneyEvent $event): Generator
    {
        $this->currentEventState = self::START_STATE;
        yield from $event->OnStart();
        $this->currentEventState = self::EVENT_STATE;
        yield from $event->OnEvent();
        $this->currentEventState = self::STOP_STATE;
        yield from $event->OnStop();
        $this->resetEvent();
    }

    private function resetEvent(): void
    {
        $this->currentEventState = null;
        $this->currentEvent = null;
    }

    public function tryStopEvent(): bool
    {
        if (!$this->eventInProgress()) {
            return false;
        }

        if ($this->currentEventState == self::STOP_STATE) {
            return false;
        }

        CoroutineManager::stopAllCoroutines();
        CoroutineManager::StartCoroutine($this->executeStopEvent($this->currentEvent));
        $this->currentEventState = self::STOP_STATE;
        return true;
    }

    private function executeStopEvent(IHoneyEvent $event): Generator
    {
        $this->currentEventState = self::STOP_STATE;
        yield from $event->OnStop();
        $this->resetEvent();
    }

    public function tryForceStopEvent(): bool
    {
        if (!$this->eventInProgress()) {
            return false;
        }

        CoroutineManager::stopAllCoroutines();
        $this->resetEvent();
        return true;
    }

    public function tryExecuteActionEvent(Player $player): bool
    {
        if (!$this->eventInProgress()) {
            return false;
        }

        CoroutineManager::StartCoroutine($this->executeActionEvent($player, $this->currentEvent));
    }

    private function executeActionEvent(Player $player, IHoneyEvent $event): Generator
    {
        yield from $event->ActionEvent($player);
    }
}