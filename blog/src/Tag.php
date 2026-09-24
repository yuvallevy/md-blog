<?php

declare(strict_types=1);

namespace Blog;

/**
 * A single tag on a post, with a display name as written in the front matter and a slug to use in URLs.
 */
final class Tag {
    private static ?PunctuationAwareSlugNormalizer $slugNormalizer = null;

    private function __construct(
        public readonly string $name,
        public readonly string $slug,
    ) {
    }

    public static function fromName(string $name): self {
        return new self(trim($name), self::slugify($name));
    }

    public function url(): string {
        return '/blog/?tag=' . $this->slug;
    }

    private static function slugify(string $name): string {
        self::$slugNormalizer ??= new PunctuationAwareSlugNormalizer();
        return self::$slugNormalizer->normalize($name);
    }
}
