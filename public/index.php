<?php

use App\Core\App;
use App\Core\Extend;
use App\Core\Roots;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

const KIRBY_HELPER_DUMP = false;
const KIRBY_HELPER_E = false;
const INDEX_DIR = __DIR__;
define("START_TIMER", microtime(true));

include dirname(__DIR__) . '/bootstrap.php';

$kirby = new App();

// Uncomment this line to use Laravel Eloquent ORM
// Extend::eloquentModels(Config::get('eloquent'));

echo $kirby->render();
