<?php

use App\Core\Stacks;
use Kirby\Template\Snippet;
use Kirby\Toolkit\A;

if (! function_exists('env')) {
    function env(string $key){
        $data = parse_ini_file('.env', false, INI_SCANNER_RAW);
        return A::get($data, $key);
    }
}

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

