<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\MarkdownConverter;

/**
 * A slightly-nerfed Markdown pipeline for front matter `title`/`subtitle`,
 * single-line strings that live outside the post body. Gets emphasis,
 * inline code, and smart quotes/dashes (same SmartPunctExtension as the
 * post body), but skips GFM (no tables/strikethrough/autolinks there),
 * front matter, pandoc attributes, and the fenced-code chrome renderer.
 *
 * This pipeline is deliberately limited to whatever markup can be safely
 * rendered in a single <p>. If the result escapes this scope, the fallback
 * is plain escaped text, which is safe for any HTML context (e.g. <title> or <meta>).
 */
final class InlineMarkdown {
    public static function render(string $text): string {
        $html = (string) self::converter()->convert($text);

        // If the rendered HTML is a single <p>...</p>,
        // strip the <p> tags and return just the inner content.
        if (preg_match('/^<p>(.*)<\/p>\s*$/s', $html, $matches) === 1) {
            return $matches[1];
        }

        // Otherwise, return the original string escaped for HTML.
        return htmlspecialchars($text, ENT_QUOTES);
    }

    /** Plain text for contexts that can't hold markup, e.g. <title> or <meta>. */
    public static function plainText(string $renderedHtml): string {
        return html_entity_decode(strip_tags($renderedHtml), ENT_QUOTES | ENT_HTML5);
    }

    private static function converter(): MarkdownConverter {
        $environment = new Environment();

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new SmartPunctExtension());

        return new MarkdownConverter($environment);
    }
}
