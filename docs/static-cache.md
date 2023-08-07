# Kirby Static Cache

Static site performance on demand!

Static Cache will give you the performance of a static site generator for your regular Kirby installations. Without a huge setup or complex deployment steps, you can run your Kirby site on any server – cheap shared hosting, VPS, you name it – and enable the static cache to get incredible speed on demand.

With custom ignore rules, you can even mix static and dynamic content. Keep some pages static while others are still served live by Kirby.

The static cache will automatically be flushed whenever content gets updated in the Panel. It's truly the best of both worlds.

Rough benchmark comparison for our Starterkit home page:

Without page cache: ~70 ms  
With page cache: ~30 ms   
With static cache: ~10 ms

## Limitations

A statically cached page will prevent any Kirby logic from executing. This means that Kirby can no longer differentiate between visitors and logged-in users. Every request will be served directly by your web server, even if the response would differ based on the cookies or other request headers.

If your site has any logic in controllers, page models, templates, snippets or plugins that results in different page responses depending on the request, this logic will naturally not be compatible with Staticache.

If only specific pages are affected by this, you can add them to the cache ignore list (see below) and use Staticache for the rest of your site. Otherwise, using Kirby's default page cache will be the better option overall because Kirby will automatically detect which responses can be cached and which caches can be used for the current request.


## Setup

### Cache configuration

**Basic setup:**

Staticache is a cache driver that can be activated for the pages cache:

```php
// /site/config/config.php

return [
  'cache' => [
    'pages' => [
      'active' => true,
      'type'   => 'static'
    ]
  ]
];
```

**Ignore rules:**

If you want to keep some of your pages dynamic, you can configure ignore rules like for the native pages cache: https://getkirby.com/docs/guide/cache#caching-pages

```php
// /site/config/config.php

return [
  'cache' => [
    'pages' => [
      'active' => true,
      'type'   => 'static',
      'ignore' => function ($page) {
        return $page->template()->name() === 'blog';
      }
    ]
  ]
];
```

All pages that are not ignored will automatically be cached on their first visit. Kirby will automatically purge the cache when changes are made in the Panel.

Please note that already cached pages are unaffected by changes to the `ignore` option. Your web server will pick up the already created files and will not check if the page is cacheable. If you see cached results from ignored pages, please manually clear your cache directory.

**Custom cache comment:**

Staticache adds an HTML comment like `<!-- static YYYY-MM-DDT01:02:03+00:00 -->` to the end of every cached HTML file by default. You can override or disable this comment in the cache configuration:

```php
// /site/config/config.php

return [
  'cache' => [
    'pages' => [
      'active' => true,
      'type'   => 'static',

      // disabled comment
      'comment' => '',

      // OR string value (only for HTML)
      'comment' => '<!-- your custom comment -->',

      // OR a custom closure
      'comment' => fn ($contentType) => $contentType === 'html' ? '<!-- comment -->' : ''
    ]
  ]
];
```