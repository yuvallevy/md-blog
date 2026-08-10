<?php

/** @var \Blog\Post $post */

declare(strict_types=1);

$pageTitle = $post->metadata->title . ' - ' . SITE_TITLE;
$pageDescription = $post->metadata->subtitle ?? $post->metadata->title;

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
    <div class="eyebrow">
      <time datetime="<?= $post->metadata->written->format('Y-m-d') ?>"><?= $post->metadata->written->format('F j, Y') ?></time>
      <?php if ($post->metadata->updated !== null): ?>
        &middot;
        <time datetime="<?= $post->metadata->updated->format('Y-m-d') ?>">Updated <?= $post->metadata->updated->format('F j, Y') ?></time>
      <?php endif; ?>
    </div>
    <h1><?= htmlspecialchars($post->metadata->title) ?></h1>
    <?php if ($post->metadata->subtitle !== null): ?>
      <p class="post-subtitle"><?= htmlspecialchars($post->metadata->subtitle) ?></p>
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
