<?php

/** @var list<\Blog\PostMetadata> $postMetadataList */

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;
use Blog\PostMetadata;

$pageTitle = SITE_TITLE;
$pageDescription = null;

require __DIR__ . '/fragments/layout-top.php';

echo '<ul>';
foreach ($postMetadataList as $postMetadata) {
    if ($postMetadata->draft) {
        continue;
    }

    $title = htmlspecialchars($postMetadata->title);
    $slug = htmlspecialchars($postMetadata->slug);
    echo "<li><a href=\"?slug={$slug}\">{$title}</a></li>";
}
echo '</ul>';

require __DIR__ . '/fragments/layout-bottom.php';
