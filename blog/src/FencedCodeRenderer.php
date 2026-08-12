<?php

declare(strict_types=1);

namespace Blog;

use Blog\Highlight\Languages\CSharp\CSharpLanguage;
use Blog\Highlight\Languages\Kotlin\KotlinLanguage;
use Blog\Highlight\Languages\TypeScript\TypeScriptLanguage;
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
        $this->highlighter = (new Highlighter(new CssTheme()))
            ->addLanguage(new CSharpLanguage())
            ->addLanguage(new TypeScriptLanguage())
            ->addLanguage(new KotlinLanguage());
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement {
        if (!$node instanceof FencedCode) {
            throw new InvalidArgumentException('Node must be an instance of ' . FencedCode::class);
        }

        $infoWord = $node->getInfoWords()[0] ?? '';
        $language = $infoWord !== '' ? Languages::get($infoWord) : null;

        $tokens = $this->highlighter->parse($node->getLiteral(), $language['slug'] ?? '');

        $code = new HtmlElement('code', [], $tokens);
        $pre = new HtmlElement('pre', [], $code);

        $attributes = ['class' => 'code'];
        $contents = $pre->__toString();

        if ($language !== null) {
            $figcaption = new HtmlElement('figcaption', [], htmlspecialchars($language['name'], ENT_QUOTES));
            $contents = $figcaption->__toString() . $contents;
            $attributes['class'] .= ' lang-' . $language['slug'];
            $attributes['style'] = "--lang-brand: {$language['brand']}; --lang-text: {$language['text']};";
        }

        return new HtmlElement('figure', $attributes, $contents);
    }
}
