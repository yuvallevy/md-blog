<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\CSharp;

use Blog\Highlight\Languages\CSharp\Patterns\AttributePattern;
use Blog\Highlight\Languages\CSharp\Patterns\CharPattern;
use Blog\Highlight\Languages\CSharp\Patterns\ClassNamePattern;
use Blog\Highlight\Languages\CSharp\Patterns\FunctionCallPattern;
use Blog\Highlight\Languages\CSharp\Patterns\InterpolatedStringPattern;
use Blog\Highlight\Languages\CSharp\Patterns\KeywordPattern;
use Blog\Highlight\Languages\CSharp\Patterns\MultilineCommentPattern;
use Blog\Highlight\Languages\CSharp\Patterns\NewObjectTypePattern;
use Blog\Highlight\Languages\CSharp\Patterns\NumberPattern;
use Blog\Highlight\Languages\CSharp\Patterns\OperatorPattern;
use Blog\Highlight\Languages\CSharp\Patterns\PropertyAccessPattern;
use Blog\Highlight\Languages\CSharp\Patterns\SinglelineCommentPattern;
use Blog\Highlight\Languages\CSharp\Patterns\StringPattern;
use Blog\Highlight\Languages\CSharp\Patterns\TypeNamePattern;
use Blog\Highlight\Languages\CSharp\Patterns\VerbatimStringPattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;

final class CSharpLanguage extends BaseLanguage
{
    public function getName(): string {
        return 'csharp';
    }

    public function getPatterns(): array {
        return [
            ...parent::getPatterns(),

            new OperatorPattern('=>'),
            new OperatorPattern('??='),
            new OperatorPattern('??'),
            new OperatorPattern('?.'),
            new OperatorPattern('&&'),
            new OperatorPattern('||'),
            new OperatorPattern('=='),
            new OperatorPattern('!='),
            new OperatorPattern('<='),
            new OperatorPattern('>='),

            // KEYWORDS
            new KeywordPattern('abstract'),
            new KeywordPattern('as'),
            new KeywordPattern('async'),
            new KeywordPattern('await'),
            new KeywordPattern('base'),
            new KeywordPattern('bool'),
            new KeywordPattern('break'),
            new KeywordPattern('byte'),
            new KeywordPattern('case'),
            new KeywordPattern('catch'),
            new KeywordPattern('char'),
            new KeywordPattern('checked'),
            new KeywordPattern('class'),
            new KeywordPattern('const'),
            new KeywordPattern('continue'),
            new KeywordPattern('decimal'),
            new KeywordPattern('default'),
            new KeywordPattern('delegate'),
            new KeywordPattern('do'),
            new KeywordPattern('double'),
            new KeywordPattern('else'),
            new KeywordPattern('enum'),
            new KeywordPattern('event'),
            new KeywordPattern('explicit'),
            new KeywordPattern('extern'),
            new KeywordPattern('false'),
            new KeywordPattern('finally'),
            new KeywordPattern('fixed'),
            new KeywordPattern('float'),
            new KeywordPattern('for'),
            new KeywordPattern('foreach'),
            new KeywordPattern('get'),
            new KeywordPattern('goto'),
            new KeywordPattern('if'),
            new KeywordPattern('implicit'),
            new KeywordPattern('in'),
            new KeywordPattern('init'),
            new KeywordPattern('int'),
            new KeywordPattern('interface'),
            new KeywordPattern('internal'),
            new KeywordPattern('is'),
            new KeywordPattern('lock'),
            new KeywordPattern('long'),
            new KeywordPattern('nameof'),
            new KeywordPattern('namespace'),
            new KeywordPattern('new'),
            new KeywordPattern('null'),
            new KeywordPattern('object'),
            new KeywordPattern('operator'),
            new KeywordPattern('out'),
            new KeywordPattern('override'),
            new KeywordPattern('params'),
            new KeywordPattern('partial'),
            new KeywordPattern('private'),
            new KeywordPattern('protected'),
            new KeywordPattern('public'),
            new KeywordPattern('readonly'),
            new KeywordPattern('record'),
            new KeywordPattern('ref'),
            new KeywordPattern('required'),
            new KeywordPattern('return'),
            new KeywordPattern('sbyte'),
            new KeywordPattern('sealed'),
            new KeywordPattern('set'),
            new KeywordPattern('short'),
            new KeywordPattern('sizeof'),
            new KeywordPattern('stackalloc'),
            new KeywordPattern('static'),
            new KeywordPattern('string'),
            new KeywordPattern('struct'),
            new KeywordPattern('switch'),
            new KeywordPattern('this'),
            new KeywordPattern('throw'),
            new KeywordPattern('true'),
            new KeywordPattern('try'),
            new KeywordPattern('typeof'),
            new KeywordPattern('uint'),
            new KeywordPattern('ulong'),
            new KeywordPattern('unchecked'),
            new KeywordPattern('unsafe'),
            new KeywordPattern('ushort'),
            new KeywordPattern('using'),
            new KeywordPattern('var'),
            new KeywordPattern('virtual'),
            new KeywordPattern('void'),
            new KeywordPattern('volatile'),
            new KeywordPattern('when'),
            new KeywordPattern('where'),
            new KeywordPattern('while'),
            new KeywordPattern('with'),
            new KeywordPattern('yield'),

            // COMMENTS
            new MultilineCommentPattern(),
            new SinglelineCommentPattern(),

            // TYPES
            new AttributePattern(),
            new NewObjectTypePattern(),
            new ClassNamePattern(),
            new TypeNamePattern(),

            // PROPERTIES
            new FunctionCallPattern(),
            new PropertyAccessPattern(),

            // VALUES
            new NumberPattern(),
            new VerbatimStringPattern(),
            new InterpolatedStringPattern(),
            new StringPattern(),
            new CharPattern(),
        ];
    }
}
