<?php layout() ?>
<?php snippet('intro') ?>

<ul class="grid" style="--gutter: 1.5rem">
  <?php foreach ($page->children()->listed() as $project): ?>
  <li class="column" style="--columns: 3">
    <a href="<?= $project->url() ?>">
      <figure>
        <span class="img" style="--w:4;--h:5">
          <?php if ($cover = $project->cover()): ?>
            <img src="<?= $cover->crop(400, 500)->url() ?>" alt="<?= $cover->alt()->esc() ?>">
          <?php endif ?>
        </span>
        <figcaption class="img-caption">
          <?= $project->title()->esc() ?>
        </figcaption>
      </figure>
    </a>
  </li>
  <?php endforeach ?>
</ul>
