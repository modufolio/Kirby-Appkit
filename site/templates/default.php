<?php layout() ?>

<article>
  <h1 class="h1"><?= $page->title()->esc() ?></h1>
  <div class="text">
    <?= $page->text()->kt() ?>
  </div>
</article>

