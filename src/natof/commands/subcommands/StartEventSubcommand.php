<?php

namespace natof\commands\subcommands;

use natof\HoneyParty;
use natof\utils\lang\LangManager;
use pocketmine\command\CommandSender;

class StartEventSubcommand implements ISubcommand
{

    public static function onExecute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!isset($args[0])) {
            return;
        }

        if (!HoneyParty::getInstance()->tryStartEvent($args[0])) {
            $sender->sendMessage(LangManager::getErrorMessage(LangManager::getMessage("event_already_in_progress")));
            return;
        }

        $sender->sendMessage(LangManager::getSuccesMessage(LangManager::getMessage("event_started")));
    }
}