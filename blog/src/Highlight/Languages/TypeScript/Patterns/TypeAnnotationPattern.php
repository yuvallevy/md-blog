<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'function greet(name: string): void {}', output: 'string')]
#[PatternTest(input: 'const items: Array<Foo> = []', output: 'Array')]
final readonly class TypeAnnotationPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return ':[^\S\n]*(?<match>[A-Za-z_][\w]*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
