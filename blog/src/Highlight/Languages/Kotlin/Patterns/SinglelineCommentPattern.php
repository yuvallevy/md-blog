<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '// foo', output: '// foo')]
final readonly class SinglelineCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '(?<match>\/\/(.)*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::COMMENT;
    }
}
