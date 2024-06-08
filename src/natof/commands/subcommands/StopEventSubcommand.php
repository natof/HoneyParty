<?php

namespace natof\commands\subcommands;

use natof\HoneyParty;
use natof\utils\lang\LangManager;
use pocketmine\command\CommandSender;

class StopEventSubcommand implements ISubcommand
{

    public static function onExecute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!HoneyParty::getInstance()->tryStopEvent()) {
            $sender->sendMessage(LangManager::getErrorMessage(LangManager::getMessage("event_already_in_progress")));
            return;
        }

        $sender->sendMessage(LangManager::getSuccesMessage(LangManager::getMessage("event_stopped")));
    }
}