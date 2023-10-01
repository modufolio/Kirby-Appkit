<?php

use App\Core\Stacks;
use Kirby\Template\Snippet;
use Kirby\Toolkit\A;

if (! function_exists('env')) {
    function env(string $key, $default = null)
    {
        static $loaded = [];

        if (empty($loaded) && file_exists(__DIR__ . '/.env')) {
            $loaded = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);
            foreach ($loaded as &$value) {
                $value = trim($value);
                $value = in_array($value, ['true', 'false']) ? ($value === 'true') : $value;
            }
        }

        return $_ENV[$key] ?? $_SERVER[$key] ?? $loaded[$key] ?? $default;
    }
}

function static_cache(): void
{
    $root = __DIR__ . '/storage/cache';

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
};


if (! function_exists('layout')) {
    function layout($name = 'default', ?array $data = []): Snippet
    {
        return Snippet::begin(
            file: kirby()->root('site') . '/layouts/' . $name . '.php',
            data: $data
        );
    }
}
if (! function_exists('endpush')) {
    function endpush(): void
    {
        Stacks::end();
    }
}
if (! function_exists('push')) {
    function push(string $name, bool $once = false): void
    {
        Stacks::open($name, $once);
    }
}
if (! function_exists('stack')) {
    function stack(string $name, bool $return = false): string|null
    {
        return Stacks::render($name, $return);
    }
}

