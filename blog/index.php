<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Blog\PostRepository;

$repository = new PostRepository(__DIR__ . '/posts');

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
