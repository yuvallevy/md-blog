<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public List<Foo> Items { get; }', output: 'List')]
final readonly class TypeNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?<match>[A-Z][A-Za-z0-9_]*)\b(?!\()';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
