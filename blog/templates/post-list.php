<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

$posts = [];

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

    $posts[] = [
        'slug' => $slug,
        ...$frontMatter,
    ];
}

usort($posts, static fn (array $a, array $b): int => strtotime((string) ($b['written'] ?? 0)) <=> strtotime((string) ($a['written'] ?? 0)));

echo '<ul>';
foreach ($posts as $post) {
    if (!empty($post['draft'])) {
        continue;
    }

    $title = htmlspecialchars((string) ($post['title'] ?? $post['slug']));
    $slug = htmlspecialchars((string) ($post['slug'] ?? ''));
    echo "<li><a href=\"?slug={$slug}\">{$title}</a></li>";
}
echo '</ul>';
