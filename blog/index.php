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
