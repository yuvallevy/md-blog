<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\SmartPunct\Quote;
use League\CommonMark\Node\StringContainerInterface;

/**
 * Fixes mis-oriented apostrophes that are incorrectly marked as openers.
 * Happens when a single quote follows punctuation and precedes a letter,
 * such as in "C#'s".
 */
final class FixMisplacedApostrophesListener {
    public function __invoke(DocumentParsedEvent $event): void {
        foreach ($event->getDocument()->iterator() as $node) {
            if (!$node instanceof Quote ||
                $node->getLiteral() !== Quote::SINGLE_QUOTE_OPENER) {
                continue;
            }

            $previous = $node->previous();
            $next = $node->next();

            $precededByPunctuation = $previous instanceof StringContainerInterface
                && preg_match('/\p{P}$/u', $previous->getLiteral()) === 1;
            $followedByLetter = $next instanceof StringContainerInterface
                && preg_match('/^\p{L}/u', $next->getLiteral()) === 1;

            if ($precededByPunctuation && $followedByLetter) {
                $node->setLiteral(Quote::SINGLE_QUOTE_CLOSER);
            }
        }
    }
}
