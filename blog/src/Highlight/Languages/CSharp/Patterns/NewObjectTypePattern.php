<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'new Dictionary<string, int>()', output: 'Dictionary')]
final readonly class NewObjectTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\bnew\s+(?<match>[A-Z][\w]*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
