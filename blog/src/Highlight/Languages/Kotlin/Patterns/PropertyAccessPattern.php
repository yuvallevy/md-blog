<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'foo.bar', output: 'bar')]
final readonly class PropertyAccessPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '[\w]+\.(?<match>[A-Za-z_][\w]*)(?!\()';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::PROPERTY;
    }
}
