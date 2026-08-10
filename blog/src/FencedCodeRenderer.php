<?php

declare(strict_types=1);

namespace Blog;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

/**
 * Renders fenced code blocks with a caption indicating the language.
 * 
 *   <figure class="code lang-{slug}">
 *     <figcaption>{Language Name}</figcaption>
 *     <pre>{code}</pre>
 *   </figure>
 */
final class FencedCodeRenderer implements NodeRendererInterface {
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement {
        if (!$node instanceof FencedCode) {
            throw new InvalidArgumentException('Node must be an instance of ' . FencedCode::class);
        }

        $infoWord = $node->getInfoWords()[0] ?? '';
        $language = Languages::get($infoWord);

        $code = htmlspecialchars($node->getLiteral(), ENT_QUOTES);

        $figcaption = new HtmlElement('figcaption', [], htmlspecialchars($language['name'], ENT_QUOTES));
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
