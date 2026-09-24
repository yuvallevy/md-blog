<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Blog\PostRepository;
use Blog\RenderCache;

// Real content/config, when present, always wins over the committed
// examples - config.php and posts/ are both gitignored, so a fresh clone
// falls back to the blank-slate defaults until you add your own.
$config = require is_file(__DIR__ . '/config.php') ? __DIR__ . '/config.php' : __DIR__ . '/config.example.php';

$postsDirectory = is_dir(__DIR__ . '/posts') && glob(__DIR__ . '/posts/*.md') !== []
    ? __DIR__ . '/posts'
    : __DIR__ . '/example-posts';

$repository = new PostRepository(
    $postsDirectory,
    new RenderCache(__DIR__ . '/cache'),
);

// If a tag slug is given, filter the list of posts to only those with the matching tag
$tagSlug = $_GET['tag'] ?? null;

if ($tagSlug !== null) {
    $tagSlug = strtolower(is_string($tagSlug) ? $tagSlug : '');
    $postMetadataList = $repository->listPublishedByTag($tagSlug);

    // If no posts were found with the given tag, show a 404 page, as if navigating to a nonexistent page
    if ($postMetadataList === []) {
        http_response_code(404);
        require __DIR__ . '/templates/404.php';
        return;
    }

    // If any posts were found, use the first matched post to reconstruct the tag's display name
    $tag = $postMetadataList[0]->tagBySlug($tagSlug);
    require __DIR__ . '/templates/post-list.php';
    return;
}

$slug = $_GET['slug'] ?? null;

if ($slug === null) {
    $postMetadataList = $repository->listPublished();
    require __DIR__ . '/templates/post-list.php';
    return;
}

$post = $repository->loadBySlug(is_string($slug) ? $slug : '');

if ($post === null) {
    http_response_code(404);
    require __DIR__ . '/templates/404.php';
    return;
}

require __DIR__ . '/templates/post.php';
