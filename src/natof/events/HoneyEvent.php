<?php

namespace natof\events;

use Generator;
use natof\IHoneyEvent;
use natof\utils\coroutine\yieldOperation\WaitForObjective;
use natof\utils\coroutine\yieldOperation\WaitForSeconds;
use pocketmine\player\Player;

class HoneyEvent implements IHoneyEvent
{
    public $test = 0;

    public function OnStart(): Generator
    {
        //Attend que le callback return true pour continuer a lire le code
        yield new WaitForObjective(function () {

            //Check la condition est good
            if ($this->test == 1) {
                return true;
            }

            //Attend 20 seconds
            yield new WaitForSeconds(20);

            //set test a 1
            $this->test = 1;
            return false;
        });


        var_dump("test");
    }

    public function OnEvent(): Generator
    {
        var_dump("event");
        yield new WaitForObjective(20);
    }

    public function OnStop(): Generator
    {
        var_dump("stop");
        yield new WaitForObjective(20);
    }

    public function getName(): string
    {
        return "test";
    }

    public function ActionEvent(Player $player): Generator
    {
        $player->sendMessage("teleport in event");
    }
}