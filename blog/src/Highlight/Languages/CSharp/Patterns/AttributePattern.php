<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '[Serializable]', output: 'Serializable')]
#[PatternTest(input: '[Obsolete("old")]', output: 'Obsolete')]
final readonly class AttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\[(?<match>[A-Za-z_][\w]*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::ATTRIBUTE;
    }
}
