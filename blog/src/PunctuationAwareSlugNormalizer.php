<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Normalizer\SlugNormalizer;
use League\CommonMark\Normalizer\TextNormalizerInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

/**
 * An extension of CommonMark's built-in slug normalizer that handles special cases related to punctuation.
 * e.g. "An A+-worthy essay about C#'s type system" will be correctly slugged as
 * "an-a-plus-worthy-essay-about-c-sharps-type-system".
 */
final class PunctuationAwareSlugNormalizer implements TextNormalizerInterface, ConfigurationAwareInterface {
    private readonly SlugNormalizer $inner;

    /**
     * These substitutions will be applied to the text before it is passed to the inner slug normalizer.
     * Each key is a regular expression pattern, and each value is the replacement string.
     */
    private array $substitutions = [
        '/(?<=\b[A-D])\+(?![A-Z0-9+])/' => '-plus',
        '/(?<=\b[A-G])#(?![A-Z0-9])/' => '-sharp',
        '/\bC\+\+/' => 'cpp',
    ];

    public function __construct() {
        $this->inner = new SlugNormalizer();
    }

    /**
     * Sets the configuration for the slug normalizer.
     * This method is required as part of implementing `ConfigurationAwareInterface`, though all it does in this case
     * is pass the configuration to the inner `SlugNormalizer` object.
     */
    public function setConfiguration(ConfigurationInterface $configuration): void {
        $this->inner->setConfiguration($configuration);
    }

    /**
     * Where the magic happens. This method applies the defined substitutions to the heading text
     * and then delegates to the inner slug normalizer to produce the final slug.
     */
    public function normalize(string $text, array $context = []): string {
        if ($this->substitutions === []) {
            return $this->inner->normalize($text, $context);
        }

        foreach ($this->substitutions as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }

        return $this->inner->normalize($text, $context);
    }
}
