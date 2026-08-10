<?php

declare(strict_types=1);

namespace Blog;

/**
 * Dead-simple render cache, generating one HTML file per post.
 * Cached files are stale when the source markdown is newer.
 * The whole cache directory is safe to delete at any time;
 * a miss just re-renders the page and rewrites the result to the cache.
 */
final class RenderCache {
    public function __construct(private readonly string $cacheDir) {
    }

    public function get(string $slug, string $sourcePath): ?string {
        $cachePath = $this->pathFor($slug);

        if (!is_file($cachePath) || !is_file($sourcePath)) {
            return null;
        }

        if (filemtime($cachePath) < filemtime($sourcePath)) {
            return null;
        }

        $contents = file_get_contents($cachePath);

        return $contents === false ? null : $contents;
    }

    public function put(string $slug, string $html): void {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0775, true);
        }

        file_put_contents($this->pathFor($slug), $html);
    }

    private function pathFor(string $slug): string {
        return rtrim($this->cacheDir, '/') . '/' . $slug . '.html';
    }
}
