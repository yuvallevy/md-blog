<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'fun doWork()', output: 'doWork')]
final readonly class FunctionNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\bfun\s+(?<match>[A-Za-z_][\w]*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::PROPERTY;
    }
}
