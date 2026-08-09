<?php

/** @var list<\Blog\PostMetadata> $postMetadataList */

declare(strict_types=1);

$pageTitle = SITE_TITLE;
$pageDescription = null;

require __DIR__ . '/fragments/layout-top.php';
?>

<ul>
  <?php foreach ($postMetadataList as $postMetadata): ?>
    <li>
      <a href="/blog/<?= htmlspecialchars($postMetadata->slug) ?>">
        <?= htmlspecialchars($postMetadata->title) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<?php
require __DIR__ . '/fragments/layout-bottom.php';
