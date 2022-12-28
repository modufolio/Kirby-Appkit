<?php

namespace App\Core;

use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Illuminate\Database\Capsule\Manager as Capsule;

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

    public static function eloquentModels(array $config){
        $capsule = new Capsule;
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

}
