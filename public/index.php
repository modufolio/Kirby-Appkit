<?php

use App\Core\App;
use App\Core\Extend;
use App\Core\Roots;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

(function /* staticCache */ () {
    $root = dirname(__DIR__) . '/storage/cache';

    // check if a cache for this domain exists
    $root .= '/pages';
    if (is_dir($root) !== true) {
        return;
    }

    // determine the exact file to use
    $path = $root . '/' . ltrim($_SERVER['REQUEST_URI'] ?? '', '/');
    if (is_file($path . '/index.html') === true) {
        // a HTML representation exists in the cache
        $path = $path . '/index.html';
    } elseif (is_file($path) !== true) {
        // neither a HTML representation nor a custom
        // representation exists in the cache
        return;
    }

    // try to determine the content type from the static file
    if ($mime = @mime_content_type($path)) {
        header("Content-Type: $mime");
    }

    die(file_get_contents($path));
})();

const KIRBY_HELPER_DUMP = false;
const KIRBY_HELPER_E = false;
const INDEX_DIR = __DIR__;
define("START_TIMER", microtime(true));

include dirname(__DIR__) . '/bootstrap.php';

$kirby = new App();

// Uncomment this line to use Laravel Eloquent ORM
// Extend::eloquentModels(Config::get('eloquent'));

echo $kirby->render();
