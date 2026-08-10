<?php

declare(strict_types=1);

namespace Blog;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\CssTheme;

/**
 * Renders fenced code blocks with Tempest highlighting and a caption indicating the language.
 * 
 *   <figure class="code lang-{slug}">
 *     <figcaption>{Language Name}</figcaption>
 *     <pre><code>{tokens}</code></pre>
 *   </figure>
 */
final class FencedCodeRenderer implements NodeRendererInterface {
    private Highlighter $highlighter;

    public function __construct() {
        $this->highlighter = new Highlighter(new CssTheme());
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement {
        if (!$node instanceof FencedCode) {
            throw new InvalidArgumentException('Node must be an instance of ' . FencedCode::class);
        }

        $infoWord = $node->getInfoWords()[0] ?? '';
        $language = Languages::get($infoWord);

        $tokens = $this->highlighter->parse($node->getLiteral(), $language['slug']);

        $figcaption = new HtmlElement('figcaption', [], htmlspecialchars($language['name'], ENT_QUOTES));
        $code = new HtmlElement('code', [], $tokens);
        $pre = new HtmlElement('pre', [], $code);
        return new HtmlElement(
            'figure',
            [
                'class' => 'code lang-' . $language['slug'],
                'style' => "--lang-brand: {$language['brand']}; --lang-text: {$language['text']};",
            ],
            $figcaption->__toString() . $pre->__toString(),
        );
    }
}
