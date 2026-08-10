<?php

/** @var list<\Blog\PostMetadata> $postMetadataList */

declare(strict_types=1);

$pageTitle = SITE_TITLE;
$pageDescription = null;

require __DIR__ . '/fragments/layout-top.php';
?>

<section id="blog-index">
  <div class="eyebrow">Lessons from the workbench</div>
  <h1>What I&rsquo;ve learned about software.</h1>

  <?php if ($postMetadataList === []): ?>
    <p class="muted">Nothing here yet - check back soon.</p>
  <?php else: ?>
    <ul class="post-list">
      <?php foreach ($postMetadataList as $postMetadata): ?>
        <li class="post-list-item">
          <a href="/blog/<?= htmlspecialchars($postMetadata->slug) ?>">
            <h2><?= $postMetadata->title ?></h2>
            <?php if ($postMetadata->subtitle !== null): ?>
              <p class="post-subtitle"><?= $postMetadata->subtitle ?></p>
            <?php endif; ?>
            <time datetime="<?= $postMetadata->written->format('Y-m-d') ?>"><?= $postMetadata->written->format('F j, Y') ?></time>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<?php
require __DIR__ . '/fragments/layout-bottom.php';
