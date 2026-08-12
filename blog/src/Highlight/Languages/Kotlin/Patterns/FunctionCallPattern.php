<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'doWork()', output: 'doWork')]
#[PatternTest(input: '.doWork()', output: 'doWork')]
final readonly class FunctionCallPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?<match>[A-Za-z_][\w]*)(?=\()';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::PROPERTY;
    }
}
