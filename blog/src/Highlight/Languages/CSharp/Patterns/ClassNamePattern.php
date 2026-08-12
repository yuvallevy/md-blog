<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'public class UserService', output: 'UserService')]
#[PatternTest(input: 'record Point(int X, int Y);', output: 'Point')]
final readonly class ClassNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?:class|struct|record|interface|enum)\s+(?<match>[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
