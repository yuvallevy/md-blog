<?php
/** @var string $filename */

declare(strict_types=1);

$rawPost = file_get_contents($filename);

// Find first instance of --- directly before AND after a newline
$frontMatterEnd = strpos($rawPost, "\n---\n", 4) + strlen("\n---\n");
// The post content is everything after that, trimmed of leading and trailing whitespace.
$markdown = trim(substr($rawPost, $frontMatterEnd));

$html = $converter->convert($markdown);

require __DIR__ . '/fragments/layout-top.php';

echo $html;

require __DIR__ . '/fragments/layout-bottom.php';
