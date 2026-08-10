<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\Attributes\AttributesExtension;
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
        $environment->addExtension(new FrontMatterExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer(), 10);

        return new MarkdownConverter($environment);
    }

    /**
     * Converts raw markdown with leading YAML front matter to
     * [html body, front matter array].
     *
     * @return array{0: string, 1: array<string, mixed>}
     */
    public static function render(string $markdown): array {
        $result = self::converter()->convert($markdown);

        $frontMatter = $result instanceof RenderedContentWithFrontMatter
            ? $result->getFrontMatter()
            : [];

        return [(string) $result, $frontMatter];
    }
}
