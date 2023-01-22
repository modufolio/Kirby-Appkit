<?php

use Kirby\Template\Snippet;
use Kirby\Toolkit\A;

if (! function_exists('env')) {
    function env(string $key){
        $data = parse_ini_file('.env', true);
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


