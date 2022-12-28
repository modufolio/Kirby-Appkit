<?php

use App\Core\App;
use App\Core\Extend;
use App\Core\Roots;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

const KIRBY_HELPER_DUMP = false;
const KIRBY_HELPER_E = false;
define("START_TIMER", microtime(true));

include dirname(__DIR__) . '/bootstrap.php';

const INDEX_DIR = __DIR__;

$kirby = new App([
    'roots' => [
        'index'    => __DIR__,
        'base'     => $base    = dirname(__DIR__),
        'config'     => $base . '/config',
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
Extend::eloquentModels(Config::get('eloquent'));

echo $kirby->render();
