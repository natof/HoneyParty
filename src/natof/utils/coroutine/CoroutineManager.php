<?php

namespace natof\utils\coroutine;

use Generator;

class CoroutineManager
{
    private static $activeCoroutines = [];

    public static function startCoroutine(Generator $routine)
    {
        self::$activeCoroutines[] = new Coroutine($routine);
    }

    public static function stopCoroutine(Generator $routine)
    {
        foreach (self::$activeCoroutines as $key => $coroutine) {
            if ($coroutine->getRoutine() === $routine) {
                $coroutine->stop();
                unset(self::$activeCoroutines[$key]);
                break;
            }
        }
    }

    public static function stopAllCoroutines()
    {
        foreach (self::$activeCoroutines as $coroutine) {
            $coroutine->stop();
        }
        self::$activeCoroutines = [];
    }

    public static function onTick()
    {
        foreach (self::$activeCoroutines as $key => $coroutine) {
            if (!$coroutine->moveNext()) {
                unset(self::$activeCoroutines[$key]);
            }
        }
    }
}