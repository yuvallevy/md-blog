<?php

declare(strict_types=1);

namespace Blog;

use DateTimeImmutable;

final class PostMetadata {
    public function __construct(
        public readonly string $slug,
        public readonly string $title,
        public readonly ?string $subtitle,
        public readonly ?DateTimeImmutable $written,
        public readonly ?DateTimeImmutable $updated,
        public readonly array $reviewers,
        public readonly bool $draft,
    ) {
    }

    /** @param array<string, mixed> $frontMatter */
    public static function fromFrontMatter(string $slug, array $frontMatter): self {
        $draft = (bool) ($frontMatter['draft'] ?? false);
        $written = self::parseDate($frontMatter['written'] ?? null);

        // `written` is required for a published post (it drives index sort
        // order and display), but a draft may not have one yet.
        if ($written === null && !$draft) {
            $written = new DateTimeImmutable('@0');
        }

        return new self(
            slug: $slug,
            title: (string) ($frontMatter['title'] ?? $slug),
            subtitle: isset($frontMatter['subtitle']) ? (string) $frontMatter['subtitle'] : null,
            written: $written,
            updated: self::parseDate($frontMatter['updated'] ?? null),
            reviewers: array_map('strval', (array) ($frontMatter['reviewers'] ?? [])),
            draft: $draft,
        );
    }

    /**
     * Symfony's YAML parser resolves bare `YYYY-MM-DD` to a Unix
     * timestamp (int) rather than a string or DateTime instance, but keeps quoted strings as-is.
     * Since we may encounter both, we handle both cases here.
     */
    private static function parseDate(mixed $value): ?DateTimeImmutable {
        if ($value === null) {
            return null;
        }

        if (is_int($value)) {
            return (new DateTimeImmutable('@' . $value))->setTimezone(new \DateTimeZone('UTC'));
        }

        return new DateTimeImmutable((string) $value);
    }
}
