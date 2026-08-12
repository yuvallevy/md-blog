<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'Promise<Foo>', output: 'Foo')]
final readonly class GenericTypeArgumentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '<(?<match>[A-Z][\w]*)>';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
