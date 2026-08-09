<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;
use Blog\PostMetadata;

$postMetadataList = [];

$frontMatterMarker = "---\n";

/** @return array<string, mixed>|null */
function readFrontMatter(string $path): ?array {
    $handle = fopen($path, 'r');

    $frontMatterYamlString = "";

    if ($handle === false) {
        return null;
    }

    $isFirstLine = true;

    while (($line = fgets($handle)) !== false) {
        // The first line should contain nothing but the front matter marker.
        // If it's not, then this file doesn't have front matter; return early.
        if ($isFirstLine) {
            $isFirstLine = false;

            if ($line !== $GLOBALS['frontMatterMarker']) {
                fclose($handle);
                return null;
            }

            continue;
        }

        // Subsequent lines are part of the front matter until we hit the closing marker.
        if ($line === $GLOBALS['frontMatterMarker']) {
            break;
        }

        // For each successive line, append it to the front matter string.
        $frontMatterYamlString .= $line;
    }

    fclose($handle);

    if ($frontMatterYamlString === "") {
        return null;
    }

    return Yaml::parse($frontMatterYamlString);
}

foreach (glob(__DIR__ . '/../posts/*.md') ?: [] as $path) {
    $slug = basename($path, '.md');
    $frontMatter = readFrontMatter($path);

    if ($frontMatter === null) {
        continue;
    }

    $postMetadataList[] = PostMetadata::fromFrontMatter($slug, $frontMatter);
}

usort($postMetadataList, static fn (PostMetadata $a, PostMetadata $b): int => $b->written <=> $a->written);

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
