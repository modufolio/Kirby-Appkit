<?php layout() ?>

<?php if (empty($tag) === false): ?>
<header class="h1">
  <h1>
    <small>Tag:</small> <?= esc($tag) ?>
    <a href="<?= $page->url() ?>" aria-label="All Notes">&times;</a>
  </h1>
</header>
<?php else: ?>
  <?php snippet('intro') ?>
<?php endif ?>

<ul class="grid">
  <?php foreach ($notes as $note): ?>
  <li class="column" style="--columns: 4">
      <?php snippet('note', ['note' => $note]) ?>
  </li>
  <?php endforeach ?>
</ul>

<?php snippet('pagination', ['pagination' => $notes->pagination()]) ?>

