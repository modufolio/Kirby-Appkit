<?php

namespace App\Core;

use Kirby\Cms\Pages;
use Kirby\Toolkit\Config;

final class Site extends \Kirby\Cms\Site
{
    /**
     * Add virtual children to existing children
     */
    public function children() {
        // get existing children
        $children = parent::children();

        // pass virtual children data to the Pages::factory() methods
        $virtualChildren = Pages::factory(Config::get('pages'), $this);
        // return merged collection
        return $children->merge($virtualChildren);
    }
}