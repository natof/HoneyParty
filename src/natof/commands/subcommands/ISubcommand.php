<?php

namespace natof\commands\subcommands;

use pocketmine\command\CommandSender;

interface ISubcommand
{

    public static function onExecute(CommandSender $sender, string $commandLabel, array $args): void;
}