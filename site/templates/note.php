<?php layout() ?>

<?php if ($cover = $page->cover()): ?>
<a href="<?= $cover->url() ?>" data-lightbox class="img" style="--w:2; --h:1">
  <img src="<?= $cover->crop(1200, 600)->url() ?>" alt="<?= $cover->alt()->esc() ?>">
</a>
<?php endif ?>

<article class="note">
  <header class="note-header h1">
    <h1 class="note-title"><?= $page->title()->esc() ?></h1>
    <?php if ($page->subheading()->isNotEmpty()): ?>
    <p class="note-subheading"><small><?= $page->subheading()->esc() ?></small></p>
    <?php endif ?>
  </header>
  <div class="note text">
    <?= $page->text()->toBlocks() ?>
  </div>
  <footer class="note-footer">
    <?php if (!empty($tags)): ?>
    <ul class="note-tags">
      <?php foreach ($tags as $tag): ?>
      <li>
        <a href="<?= $page->parent()->url(['params' => ['tag' => $tag]]) ?>"><?= esc($tag) ?></a>
      </li>
      <?php endforeach ?>
    </ul>
    <?php endif ?>

    <time class="note-date" datetime="<?= $page->date()->toDate('c') ?>">Published on <?= $page->date()->esc() ?></time>
  </footer>

  <?php snippet('prevnext') ?>
</article>

