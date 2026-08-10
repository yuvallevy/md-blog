<?php

declare(strict_types=1);

const SITE_TITLE = 'yuvallevy.dev blog';
const DEFAULT_AUTHOR = 'Yuval Levy';

require __DIR__ . '/vendor/autoload.php';

use Blog\PostRepository;
use Blog\RenderCache;

$repository = new PostRepository(
    __DIR__ . '/posts',
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
