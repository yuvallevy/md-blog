<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(
    input: 'val s = """
hello
"""',
    output: '"""
hello
"""'
)]
final readonly class TripleQuotedStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '/(?<match>"""(.|\n)*?""")/m';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::VALUE;
    }
}
