<?php

namespace natof;

use natof\commands\eventCommand;
use natof\events\HoneyEvent;
use natof\listeners\playerListener;
use natof\managers\EventManager;
use natof\tasks\CoroutineTask;
use natof\utils\coroutine\yieldOperation\WaitForTicks;
use natof\utils\lang\LangManager;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class HoneyParty extends PluginBase
{
    use SingletonTrait;
    use EventManager;

    private const STOP_STATE = "stop";
    private const START_STATE = "start";
    private const EVENT_STATE = "event";
    private $events = [];
    private $config;

    protected function onEnable(): void
    {
        $this->getScheduler()->scheduleRepeatingTask(new CoroutineTask(), 1);
        Server::getInstance()->getCommandMap()->register("event", new eventCommand());

        $this->initConfig();
        LangManager::loadLang();

        //TODO REMOVE THIS
        HoneyParty::getInstance()->registerEvent(new HoneyEvent());


        $this->getLogger()->info(TextFormat::GREEN . "Plugin " . TextFormat::AQUA . "honeyParty" . TextFormat::GREEN . " by " . TextFormat::YELLOW . "natof" . TextFormat::GREEN . " has been enabled!");
        $this->getLogger()->info(TextFormat::GREEN . "Registered " . TextFormat::YELLOW . count($this->events) . " events" . TextFormat::GREEN . ".");
        parent::onEnable();
    }

    private function initConfig(): void
    {
        $this->saveResource('config.yml');
        @mkdir($this->getDataFolder() . "lang");
        $this->saveResource('lang/en.yml');
        $this->saveResource('lang/fr.yml');
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }
}