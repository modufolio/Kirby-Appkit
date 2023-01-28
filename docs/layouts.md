# Kirby Layouts

You can create full HTML layouts in a new `/site/layouts` folder. Layouts can define slots, which will then be filled with content by templates. Layouts are based on our new snippets with slots and work exactly the same way. The only difference is the folder location. You can learn more about our snippets with slots in our docs: http://getkirby.com/docs/guide/templates/snippets#passing-slots-to-snippets

#### /site/layouts/default.php

```html
<html>
  <head>
    <title><?= $page->title() ?></title>
  </head>
  <body>
    <?= $slot ?>
  </body>
</html>
```

#### /site/templates/default.php

```html
<?php layout() ?>

<h1>Hello world</h1>
<p>This will end up in the default slot</p>
```

### Choosing a layout

To use a specific layout, you can pass its name to the `layout()` method.

#### /site/layouts/blog.php

```html
<html>
  <head>
    <title>Blog</title>
  </head>
  <body>
    <h1>Blog</h1>
    <?= $slot ?>
  </body>
</html>
```

#### /site/templates/blog.php

```html
<?php layout('blog') ?>

<!-- some articles -->
```

