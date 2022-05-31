<?php layout('blog') ?>

<?php slot('header') ?>
<title><?= site()->title() ?></title>
<?php endslot() ?>


<p>This will end up in the default slot</p>

<h1>Welcome</h1>
<p>Hello <?= esc($name) ?>!</p>

<ul>
    <?php foreach ($colours as $colour): ?>
        <li><?= esc($colour); ?></li>
    <?php endforeach; ?>
</ul>
<?php snippet('footer') ?>