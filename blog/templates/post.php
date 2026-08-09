<?php

/** @var \Blog\Post $post */

declare(strict_types=1);

$pageTitle = $post->metadata->title . ' - ' . SITE_TITLE;
$pageDescription = $post->metadata->subtitle ?? $post->metadata->title;

require __DIR__ . '/fragments/layout-top.php';
?>

<h1><?= htmlspecialchars($post->metadata->title) ?></h1>
<?php if ($post->metadata->subtitle !== null): ?>
  <p><em><?= htmlspecialchars($post->metadata->subtitle) ?></em></p>
<?php endif; ?>
<?php if ($post->metadata->draft): ?>
  <p><strong>Draft - not listed on /blog, visible only by direct link</strong></p>
<?php endif; ?>
<p><em>Published on <?= htmlspecialchars($post->metadata->written?->format('F j, Y') ?? 'Unknown date') ?> &middot; Last updated <?= htmlspecialchars($post->metadata->updated?->format('F j, Y') ?? 'Unknown date') ?></em></p>
<?php if ($post->metadata->reviewers !== []): ?>
  <p><em>Thank you to my reviewer<?= count($post->metadata->reviewers) > 1 ? 's' : '' ?>, <?= htmlspecialchars(implode(', ', $post->metadata->reviewers)) ?></em></p>
<?php endif; ?>
<div>
  <?= $post->bodyHtml ?>
</div>

<?php
require __DIR__ . '/fragments/layout-bottom.php';
