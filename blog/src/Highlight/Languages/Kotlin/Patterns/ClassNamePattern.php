<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'data class User(val id: Int)', output: 'User')]
#[PatternTest(input: 'class UserService', output: 'UserService')]
final readonly class ClassNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?:class|object|interface)\s+(?<match>[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
