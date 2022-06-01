<?php

namespace App\Core;

use Kirby\Cms\Page;
use Kirby\Cms\Pages;

class Extend
{

    /**
     * Registers additional page methods
     *
     * @param array $methods
     */
    public static function pageMethods(array $methods): void
    {
        Page::$methods = array_merge(Page::$methods, $methods);
    }

}