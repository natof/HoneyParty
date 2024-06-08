<?php

namespace natof\commands;

use natof\commands\subcommands\ForceStopEventSubcommand;
use natof\commands\subcommands\StartEventSubcommand;
use natof\commands\subcommands\StopEventSubcommand;
use natof\HoneyParty;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

class eventCommand extends Command
{
    public function __construct()
    {
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
        parent::__construct("event", "honey event command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!isset($args[0])) {
            $this->executeDefaultAction($sender);
            return;
        }

        $subcommand = $args[0];
        array_shift($args);
        switch ($subcommand) {
            case "start":
                StartEventSubcommand::onExecute($sender, $commandLabel, $args);
                break;
            case "stop":
                StopEventSubcommand::onExecute($sender, $commandLabel, $args);
                break;
            case "forcestop":
                ForceStopEventSubcommand::onExecute($sender, $commandLabel, $args);
                break;
            default:
                $this->executeDefaultAction($sender);
                break;
        }
    }

    public function executeDefaultAction(CommandSender $sender): void
    {
        if (!HoneyParty::getInstance()->eventInProgress()) {
            return;
        }

        if (!$sender instanceof Player) {
            return;
        }

        if (!HoneyParty::getInstance()->tryExecuteActionEvent($sender)) {
            $sender->sendMessage("no event in progress");
        }
    }

}