<?php

declare(strict_types=1);

namespace Blog\Highlight\Languages\Kotlin;

use Blog\Highlight\Languages\Kotlin\Patterns\AnnotationPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\CharPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\ClassNamePattern;
use Blog\Highlight\Languages\Kotlin\Patterns\FunctionCallPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\FunctionNamePattern;
use Blog\Highlight\Languages\Kotlin\Patterns\KeywordPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\MultilineCommentPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\NumberPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\OperatorPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\PropertyAccessPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\SinglelineCommentPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\StringPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\TripleQuotedStringPattern;
use Blog\Highlight\Languages\Kotlin\Patterns\TypeNamePattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;

final class KotlinLanguage extends BaseLanguage
{
    public function getName(): string {
        return 'kotlin';
    }

    public function getPatterns(): array {
        return [
            ...parent::getPatterns(),

            new OperatorPattern('->'),
            new OperatorPattern('?:'),
            new OperatorPattern('?.'),
            new OperatorPattern('!!'),
            new OperatorPattern('&&'),
            new OperatorPattern('||'),
            new OperatorPattern('=='),
            new OperatorPattern('!='),
            new OperatorPattern('<='),
            new OperatorPattern('>='),

            // KEYWORDS
            new KeywordPattern('abstract'),
            new KeywordPattern('actual'),
            new KeywordPattern('annotation\sclass'),
            new KeywordPattern('as'),
            new KeywordPattern('break'),
            new KeywordPattern('by'),
            new KeywordPattern('catch'),
            new KeywordPattern('class'),
            new KeywordPattern('companion'),
            new KeywordPattern('const'),
            new KeywordPattern('constructor'),
            new KeywordPattern('continue'),
            new KeywordPattern('crossinline'),
            // `data` is not a keyword by itself; `data class` and `data object` are.
            new KeywordPattern('data\sclass'),
            new KeywordPattern('data\sobject'),
            new KeywordPattern('do'),
            new KeywordPattern('else'),
            new KeywordPattern('enum'),
            new KeywordPattern('expect'),
            new KeywordPattern('external'),
            new KeywordPattern('false'),
            new KeywordPattern('final'),
            new KeywordPattern('finally'),
            new KeywordPattern('for'),
            new KeywordPattern('fun'),
            new KeywordPattern('if'),
            new KeywordPattern('import'),
            new KeywordPattern('in'),
            new KeywordPattern('infix'),
            new KeywordPattern('init'),
            new KeywordPattern('inline'),
            new KeywordPattern('inner'),
            new KeywordPattern('interface'),
            new KeywordPattern('internal'),
            new KeywordPattern('is'),
            new KeywordPattern('lateinit'),
            new KeywordPattern('noinline'),
            new KeywordPattern('null'),
            new KeywordPattern('object'),
            new KeywordPattern('open'),
            new KeywordPattern('operator'),
            new KeywordPattern('out'),
            new KeywordPattern('override'),
            new KeywordPattern('package'),
            new KeywordPattern('private'),
            new KeywordPattern('protected'),
            new KeywordPattern('public'),
            new KeywordPattern('reified'),
            new KeywordPattern('return'),
            new KeywordPattern('sealed'),
            new KeywordPattern('super'),
            new KeywordPattern('suspend'),
            new KeywordPattern('tailrec'),
            new KeywordPattern('this'),
            new KeywordPattern('throw'),
            new KeywordPattern('true'),
            new KeywordPattern('try'),
            new KeywordPattern('typealias'),
            new KeywordPattern('val'),
            new KeywordPattern('var'),
            new KeywordPattern('vararg'),
            new KeywordPattern('when'),
            new KeywordPattern('where'),
            new KeywordPattern('while'),

            // COMMENTS
            new MultilineCommentPattern(),
            new SinglelineCommentPattern(),

            // TYPES
            new AnnotationPattern(),
            new ClassNamePattern(),
            new TypeNamePattern(),

            // PROPERTIES
            new FunctionNamePattern(),
            new FunctionCallPattern(),
            new PropertyAccessPattern(),

            // VALUES
            new NumberPattern(),
            new TripleQuotedStringPattern(),
            new StringPattern(),
            new CharPattern(),
        ];
    }
}
