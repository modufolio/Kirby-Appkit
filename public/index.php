<?php

use App\Core\App;
use App\Core\Extend;
use Kirby\Toolkit\Config;

define("START_TIMER", microtime(true));

include dirname(__DIR__) . '/bootstrap.php';

$kirby = new App([
    'roots' => [
        'index'    => __DIR__,
        'base'     => $base    = dirname(__DIR__),
        'site'     => $base . '/site',
        'storage'  => $storage = $base . '/storage',
        'content'  => $storage . '/content',
        'accounts' => $storage . '/accounts',
        'cache'    => $storage . '/cache',
        'logs'     => $storage . '/logs',
        'sessions' => $storage . '/sessions',
    ],

]);


$kirby->extend(['pageMethods' => Config::get('pageMethods') ]);      // Page methods

echo $kirby->render();
