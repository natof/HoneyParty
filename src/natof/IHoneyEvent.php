<?php

namespace natof;

use Generator;
use pocketmine\player\Player;

interface IHoneyEvent
{

    public function OnStart(): Generator;

    public function OnEvent(): Generator;

    public function OnStop(): Generator;

    public function ActionEvent(Player $player): Generator;

    public function getName(): string;
}