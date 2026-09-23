<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\MarkdownConverter;

/**
 * Configured Markdown environment for formatting blog posts.
 */
final class MarkdownEnvironment
{
    public static function converter(): MarkdownConverter {
        $environment = new Environment([
            'heading_permalink' => [
                'insert' => 'before',
                // Post body headings start at h2 (h1 is the page itself).
                'min_heading_level' => 2,
                'max_heading_level' => 4,
                // The id belongs on the heading itself, not on the anchor inside it.
                'apply_id_to_heading' => true,
                'id_prefix' => '',
                'fragment_prefix' => '',
                'symbol' => '',
                'title' => 'Permalink to this section',
            ],
            // Uses the custom HeadingSlugNormalizer to correctly handle headings with meaningful punctuation.
            'slug_normalizer' => [
                'instance' => new HeadingSlugNormalizer(),
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new FrontMatterExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new SmartPunctExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer(), 10);
        // SmartPunct messes up on some apostrophes, so we fix them before the extension runs
        // so it doesn't try to correct them incorrectly.
        $environment->addEventListener(DocumentParsedEvent::class, new FixMisplacedApostrophesListener(), 10);

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
