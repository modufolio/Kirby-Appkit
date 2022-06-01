<?php

namespace App\Core;

use Kirby\Cms\Pages;

final class Site extends \Kirby\Cms\Site
{
    /**
     * Add virtual children to existing children
     */
    public function children() {
        // get existing children
        $children = parent::children();

        // set up virtual pages as array
        $pages = [
            [
                'slug'     => 'login',
                'template' => 'login',
                'model'    => 'login',
                'content'  => [
                    'title' => 'Login',
                    'text'  => 'Some content here'
                ],
            ],
            [
                'slug'     => 'shop',
                'template' => 'shop',
                'model'    => 'shop',
                'content'  => [
                    'title' => 'Shop',
                    'text'  => 'Some content here'
                ],
            ],
        ];
        // pass virtual children data to the Pages::factory() methods
        $virtualChildren = Pages::factory($pages, $this);
        // return merged collection
        return $children->merge($virtualChildren);
    }
}