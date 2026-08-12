<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'var x = 12_345.67f;', output: '12_345.67f')]
final readonly class NumberPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?<match>\d[\d_]*(\.[\d_]+)?[fFdDmMuUlL]*)\b';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::NUMBER;
    }
}
