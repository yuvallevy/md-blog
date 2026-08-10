<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

/**
 * Configured Markdown environment for formatting blog posts.
 */
final class MarkdownEnvironment
{
    public static function converter(): MarkdownConverter {
        $environment = new Environment();

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        return new MarkdownConverter($environment);
    }

    public static function render(string $markdown): string {
        return (string) self::converter()->convert($markdown);
    }
}
