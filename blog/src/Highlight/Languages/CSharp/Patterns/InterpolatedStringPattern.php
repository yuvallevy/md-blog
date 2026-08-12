<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'var s = $"hello {name}";', output: '$"hello {name}"')]
final readonly class InterpolatedStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '(?<match>\$"(\\\\"|[^"\n])*")';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::VALUE;
    }
}
