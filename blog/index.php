<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

$environment = new Environment();

$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new GithubFlavoredMarkdownExtension());

$converter = new MarkdownConverter($environment);

$slug = $_GET['slug'] ?? null;

if ($slug === null) {
    require __DIR__ . '/templates/post-list.php';
    return;
}

$filename = __DIR__ . '/posts/' . ($slug ?? 'index') . '.md';

if (!file_exists($filename)) {
    http_response_code(404);
    require __DIR__ . '/templates/404.php';
    return;
}

require __DIR__ . '/templates/post.php';
