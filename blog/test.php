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

$markdown = <<<EOT
# Hello World

This is **Markdown** content with a [link](https://example.com) and some `inline code`.
EOT;

$html = $converter->convert($markdown);

echo $html;

?>