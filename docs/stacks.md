# Kirby Template Stacks

Template stacks allows you to push to named stacks which can be rendered somewhere else in another snippet or template. This idea is inspired from [Laravel Blade Stacks](https://laravel.com/docs/9.x/blade#stacks).

## Methods

### `stack()`

Calls a given stack name and prints all the items in it. The last data is printed last.

```php
  <?php stack('scripts') // directly outputted ?>
  
  <?php echo stack('scripts', true) // returns as string ?>
```

### `push()` ... `endpush()`

Pushes data to a given stack name. The sent data is thrown to the end of the stack.

```php
<?php push('scripts') ?>
    Push any content to footer multiple times from anywhere
<?php endpush() ?>
```

If the pushed data is unique and in a repeating loop, you can send the secondary parameter as `true`. For example; if you want a javascript library to be loaded only once in a blocks field.

```php
<?php push('scripts', true) ?>
    <script src="assets/js/plugins/slider.js"></script>
<?php endpush() ?>
```

## Samples

### Sample 1: with snippets and templates

#### Defining stacks
**/site/snippets/header.php**
```php
<html>
<body>
```

**/site/snippets/footer.php**
```php
  <?php stack('scripts') ?>
</body>
</html>
```

#### Pushing contents to the stack
**/site/templates/home.php**
```php
<?php snippet('header') ?>

<h1>Homepage</h1>

<?php push('scripts') ?>
    <script src="assets/js/home.js"></script>
<?php endpush() ?>

<?php snippet('footer') ?>
```

### Sample 2: with new snippets with slots feature

#### Defining stacks
**/site/snippets/layouts/default.php**

```php
<html>
<body>
  <?= $slots->default() ?>
  <?php stack('footer') ?>
</body>
</html>
```

#### Pushing contents to the stack
**/site/templates/home.php**
```php
<?php snippet('layouts/default', slots: true) ?>

<h1>Homepage</h1>

<?php push('footer') ?>
    <script src="assets/js/home.js"></script>
<?php endpush() ?>
```
