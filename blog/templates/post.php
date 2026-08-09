<?php

/** @var \Blog\Post $post */

declare(strict_types=1);

require __DIR__ . '/fragments/layout-top.php';

echo "<h1>" . htmlspecialchars($post->metadata->title) . "</h1>";
if ($post->metadata->subtitle !== null) {
    echo "<p><em>" . htmlspecialchars($post->metadata->subtitle) . "</em></p>";
}
if ($post->metadata->draft) {
    echo "<p><strong>Draft - not listed on /blog, visible only by direct link</strong></p>";
}
echo "<p><em>Published on " . htmlspecialchars($post->metadata->written?->format('F j, Y') ?? 'Unknown date') . " &middot; Last updated " . htmlspecialchars($post->metadata->updated?->format('F j, Y') ?? 'Unknown date') . "</em></p>";
echo "<p><em>Thank you to my reviewer" . (count($post->metadata->reviewers) > 1 ? 's' : '') . ", " . htmlspecialchars(implode(', ', $post->metadata->reviewers)) . "</em></p>";
echo "<div>" . $post->bodyHtml . "</div>";

require __DIR__ . '/fragments/layout-bottom.php';
