<?php layout() ?>

<article>
  <?php snippet('intro') ?>
  <div class="grid">

    <div class="column" style="--columns: 4">
      <div class="text">
        <?= $page->text() ?>
      </div>
    </div>

    <div class="column" style="--columns: 8">
      <ul class="album-gallery">
        <?php foreach ($gallery as $image): ?>
        <li>
          <a href="<?= $image->url() ?>" data-lightbox>
            <figure class="img" style="--w:<?= $image->width() ?>;--h:<?= $image->height() ?>">
              <img src="<?= $image->resize(800)->url() ?>" alt="<?= $image->alt()->esc() ?>">
            </figure>
          </a>
        </li>
        <?php endforeach ?>
      </ul>
    </div>

</article>
