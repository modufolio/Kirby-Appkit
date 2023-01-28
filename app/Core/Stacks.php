<?php

namespace App\Core;

/**
 * Kirby template stacks
 *
 * @package   Oweb
 * @author    oweb studio <contact@owebstudio.com>
 * @link      https://owebstudio.com
 * @copyright oweb studio
 * @license   MIT
 */
class Stacks
{
    protected static string|null $current = null;
    protected static bool        $once    = false;
    protected static array       $stacks  = [];
    protected static array       $uniques = [];

    public static function get($name): array
    {
        return self::$stacks[$name] ?? [];
    }

    public static function end(): void
    {
        $current = self::$current;
        $content = ob_get_clean();

        if (self::$once === true) {
            $hash = substr(hash('sha256', $content), 0, 64);

            if (in_array($hash, self::$uniques) === false) {
                self::$uniques[] = $hash;
            } else {
                $content = null;
            }
        }

        if ($content !== null) {
            self::$stacks[$current][] = $content;
        }

        self::$current = null;
        self::$once = false;
    }

    public static function open($name, bool $once = false): void
    {
        self::$current = $name;
        self::$once = $once;
        self::$stacks[$name] ??= [];

        ob_start();
    }

    public static function render(string $name, bool $return = false): string|null
    {
        $stacks = self::get($name);
        $output = implode($stacks);

        if ($return === true) {
            return $output;
        }

        echo $output;
        return null;
    }
}
