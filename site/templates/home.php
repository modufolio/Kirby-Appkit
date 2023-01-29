<?php layout() ?>

  <?php snippet('intro') ?>
  <?php
  /*
    We always use an if-statement to check if a page exists to
    prevent errors in case the page was deleted or renamed before
    we call a method like `children()` in this case
  */
  ?>
  <?php if ($photographyPage = page('photography')): ?>
  <ul class="home-grid">
    <?php foreach ($photographyPage->children()->listed() as $album): ?>
    <li>
      <a href="<?= $album->url() ?>">
        <figure>
          <?php
          /*
            The `cover()` method defined in the `album.php`
            page model can be used everywhere across the site
            for this type of page

            We can automatically resize images to a useful
            size with Kirby's built-in image manipulation API
          */
          ?>
          <?php if ($cover = $album->cover()): ?>
          <img src="<?= $cover->resize(1024, 1024)->url() ?>" alt="<?= $cover->alt()->esc() ?>">
          <?php endif ?>
          <figcaption>
            <span>
              <span class="example-name"><?= $album->title()->esc() ?></span>
            </span>
          </figcaption>
        </figure>
      </a>
    </li>
    <?php endforeach ?>
  </ul>
  <?php endif ?>

