<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\TypeScript\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'interface Point {', output: 'Point')]
#[PatternTest(input: 'type Point = {', output: 'Point')]
final readonly class InterfaceNamePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string {
        return '\b(?:interface|type)\s+(?<match>[A-Za-z_]\w*)';
    }

    public function getTokenType(): TokenTypeEnum {
        return TokenTypeEnum::TYPE;
    }
}
