<?php

namespace App\Core;

class Timer
{
    public static function app($decimals = 2): string
    {
        $time = microtime(true) - START_TIMER;
        return number_format($time * 1000, $decimals);
    }
}