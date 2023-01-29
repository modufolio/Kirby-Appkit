<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?= $site->title()->esc() ?> | <?= $page->title()->esc() ?></title>
    <?= css([
        'assets/css/prism.css',
        'assets/css/lightbox.css',
        'assets/css/index.css',
        '@auto'
    ]) ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
</head>
<body>

<header class="header">
    <a class="logo" href="<?= $site->url() ?>">
        <?= $site->title()->esc() ?>
    </a>

    <nav class="menu">
        <?php foreach ($site->children()->listed() as $item): ?>
            <a <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>"><?= $item->title()->esc() ?></a>
        <?php endforeach ?>
        <?php snippet('social') ?>
    </nav>
</header>

<main class="main">
<?= $slot ?>
</main>

<footer class="footer">
    <div class="grid">
        <div class="column" style="--columns: 8">
            <h2><a href="https://getkirby.com">Made with Kirby</a></h2>
            <p>
                Kirby: the file-based CMS that adapts to any project, loved by developers and editors alike
            </p>
        </div>
        <div class="column" style="--columns: 2">
            <h2>Pages</h2>
            <ul>
                <?php foreach ($site->children()->listed() as $example): ?>
                    <li><a href="<?= $example->url() ?>"><?= $example->title()->esc() ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="column" style="--columns: 2">
            <h2>Kirby</h2>
            <ul>
                <li><a href="https://getkirby.com">Website</a></li>
                <li><a href="https://getkirby.com/docs">Docs</a></li>
                <li><a href="https://forum.getkirby.com">Forum</a></li>
                <li><a href="https://chat.getkirby.com">Chat</a></li>
                <li><a href="https://github.com/getkirby">GitHub</a></li>
            </ul>
        </div>
    </div>
</footer>

<?= js([
    'assets/js/prism.js',
    'assets/js/lightbox.js',
    'assets/js/index.js',
    '@auto'
]) ?>

</body>
</html>