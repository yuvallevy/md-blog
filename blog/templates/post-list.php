<?php

/**
 * @var list<\Blog\PostMetadata> $postMetadataList
 * @var \Blog\Tag|null $tag  set only when the list is filtered to a single tag
 * @var array $config
 */

declare(strict_types=1);

$tag ??= null;

$eyebrow = $tag !== null ? 'Tagged' : $config['indexEyebrow'];
$heading = $tag !== null ? 'Posts tagged “' . $tag->name . '”' : $config['indexHeading'];

$pageTitle = $tag !== null ? $heading . ' - ' . $config['siteTitle'] : $config['siteTitle'];
$pageDescription = null;

require __DIR__ . '/fragments/layout-top.php';
?>

<section id="blog-index">
  <div class="eyebrow"><?= htmlspecialchars($eyebrow) ?></div>
  <h1><?= htmlspecialchars($heading) ?></h1>

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
