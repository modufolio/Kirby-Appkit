<?php

namespace App\Core;

use Kirby\Cms\Pages;
use Kirby\Toolkit\Config;

final class Site extends \Kirby\Cms\Site
{
    /**
     * Add virtual children to existing children
     */
    public function children()
    {
        // get existing children
        $children = parent::children();

        if(!is_array($pages = Config::get('pages'))) {
            return $children;
        }

        // pass virtual children data to the Pages::factory() methods
        $virtualChildren = Pages::factory($pages, $this);
        // return merged collection
        return $children->merge($virtualChildren);
    }

    /**
     * Example custom method
     *
     */
    public function sayHello(): string
    {
        return 'Hello world';
    }
}
