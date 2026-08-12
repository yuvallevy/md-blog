<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'var p = @"C:\foo";', output: '@"C:\foo"')]
#[PatternTest(input: 'var s = @"say ""hi""";', output: '@"say ""hi"""')]
final readonly class VerbatimStringPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '(?<match>\$?@"(""|[^"])*")';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::VALUE;
    }
}
