<?php

/** @var \Blog\Post $post */

declare(strict_types=1);

$pageTitle = \Blog\InlineMarkdown::plainText($post->metadata->title) . ' - ' . SITE_TITLE;
$pageDescription = \Blog\InlineMarkdown::plainText($post->metadata->subtitle ?? $post->metadata->title);

require __DIR__ . '/fragments/layout-top.php';

function friendlyList(array $items): string {
    if (count($items) === 0) {
        return '';
    }
    if (count($items) === 1) {
        return $items[0];
    }
    $lastItem = array_pop($items);
    return implode(', ', $items) . ' and ' . $lastItem;
}
?>

<article class="post<?= $post->metadata->draft ? ' is-draft' : '' ?>">
  <header class="post-header">
    <?php if ($post->metadata->written !== null || $post->metadata->updated !== null): ?>
      <div class="eyebrow">
        <?php if ($post->metadata->written !== null): ?>
          <time datetime="<?= $post->metadata->written->format('Y-m-d') ?>"><?= $post->metadata->written->format('F j, Y') ?></time>
        <?php endif; ?>
        <?php if ($post->metadata->updated !== null): ?>
          <?php if ($post->metadata->written !== null): ?>&middot;<?php endif; ?>
          <time datetime="<?= $post->metadata->updated->format('Y-m-d') ?>">Updated <?= $post->metadata->updated->format('F j, Y') ?></time>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <h1><?= $post->metadata->title ?></h1>
    <?php if ($post->metadata->subtitle !== null): ?>
      <p class="post-subtitle"><?= $post->metadata->subtitle ?></p>
    <?php endif; ?>
    <?php if ($post->metadata->reviewers !== []): ?>
      <div class="post-reviewers">
        Thank you to my reviewer<?= count($post->metadata->reviewers) === 1 ? ',' : (count($post->metadata->reviewers) === 2 ? 's,' : 's:') ?>
        <?= htmlspecialchars(friendlyList($post->metadata->reviewers)) ?>.
      </div>
    <?php endif; ?>
  </header>

  <?php if ($post->metadata->draft): ?>
    <div class="draft-banner">This is a draft post. It is not listed on the blog index, and is visible only by direct link.</div>
  <?php endif; ?>

  <div class="post-body">
    <?= $post->bodyHtml ?>
  </div>
</article>

<?php
require __DIR__ . '/fragments/layout-bottom.php';
