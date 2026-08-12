<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\TypeScript;

use Blog\Highlight\Languages\TypeScript\Patterns\DecoratorPattern;
use Blog\Highlight\Languages\TypeScript\Patterns\GenericTypeArgumentPattern;
use Blog\Highlight\Languages\TypeScript\Patterns\InterfaceNamePattern;
use Blog\Highlight\Languages\TypeScript\Patterns\TypeAnnotationPattern;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;
use Tempest\Highlight\Languages\JavaScript\Patterns\JsKeywordPattern;

final class TypeScriptLanguage extends JavaScriptLanguage
{
    public function getName(): string {
        return 'typescript';
    }

    public function getAliases(): array {
        return [];
    }

    public function getPatterns(): array {
        return [
            // Listed ahead of the inherited JS patterns so these win ties on
            // identical spans (e.g. a decorator name vs. a JS method call).
            new DecoratorPattern(),
            new InterfaceNamePattern(),
            new GenericTypeArgumentPattern(),
            new TypeAnnotationPattern(),

            ...parent::getPatterns(),

            // TypeScript-only keywords (on top of the JS/TS-ish ones JavaScriptLanguage already has)
            new JsKeywordPattern('type'),
            new JsKeywordPattern('namespace'),
            new JsKeywordPattern('declare'),
            new JsKeywordPattern('abstract'),
            new JsKeywordPattern('readonly'),
            new JsKeywordPattern('satisfies'),
            new JsKeywordPattern('keyof'),
            new JsKeywordPattern('is'),
            new JsKeywordPattern('never'),
            new JsKeywordPattern('unknown'),
            new JsKeywordPattern('any'),
            new JsKeywordPattern('undefined'),
        ];
    }
}
