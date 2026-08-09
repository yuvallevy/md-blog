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

$markdown = file_get_contents(__DIR__ . '/posts/' . ($slug ?? 'index') . '.md');

$html = $converter->convert($markdown);

echo $html;

?>