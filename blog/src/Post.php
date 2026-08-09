<?php

declare(strict_types=1);

namespace Blog;

use DateTimeImmutable;

final class Post {
    public function __construct(
        public readonly PostMetadata $metadata,
        public readonly ?string $bodyHtml = null,
    ) {
    }
}
