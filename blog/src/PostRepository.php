<?php

declare(strict_types=1);

namespace Blog;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Symfony\Component\Yaml\Yaml;

final class PostRepository {
    private static string $frontMatterMarker = "---\n";

    public function __construct(private readonly string $postsDirectory) {
    }

    /** @return list<PostMetadata> */
    public function listPublished(): array {
        $posts = [];

        foreach (glob($this->postsDirectory . '/*.md') ?: [] as $path) {
            $slug = basename($path, '.md');
            $frontMatter = self::readFrontMatter($path);

            if ($frontMatter === null) {
                continue;
            }

            $postMetadata = PostMetadata::fromFrontMatter($slug, $frontMatter);

            if (!$postMetadata->draft) {
                $posts[] = $postMetadata;
            }
        }

        usort($posts, static fn (PostMetadata $a, PostMetadata $b): int => $b->written <=> $a->written);

        return $posts;
    }

    public function loadBySlug(string $rawSlug): ?Post {
        $slug = strtolower($rawSlug);
        if (!self::isValidSlug($slug)) {
            return null;
        }

        $path = $this->postsDirectory . '/' . $slug . '.md';

        if (!file_exists($path)) {
            return null;
        }

        $frontMatter = self::readFrontMatter($path);

        if ($frontMatter === null) {
            return null;
        }

        $postMetadata = PostMetadata::fromFrontMatter($slug, $frontMatter);

        $rawPost = file_get_contents($path);
        if ($rawPost === false) {
            return null;
        }

        // Find first instance of the front matter marker directly before AND after a newline
        $frontMatterEnd = strpos($rawPost, "\n" . self::$frontMatterMarker) + strlen("\n" . self::$frontMatterMarker);
        // The post content is everything after that, trimmed of leading and trailing whitespace.
        $markdown = trim(substr($rawPost, $frontMatterEnd));
        $bodyHtml = (string) self::markdownConverter()->convert($markdown);

        return new Post($postMetadata, $bodyHtml);
    }

    /** @return array<string, mixed>|null */
    private static function readFrontMatter(string $path): ?array {
        $handle = fopen($path, 'r');

        $frontMatterYamlString = "";

        if ($handle === false) {
            return null;
        }

        $isFirstLine = true;

        while (($line = fgets($handle)) !== false) {
            // The first line should contain nothing but the front matter marker.
            // If it's not, then this file doesn't have front matter; return early.
            if ($isFirstLine) {
                $isFirstLine = false;

                if ($line !== self::$frontMatterMarker) {
                    fclose($handle);
                    return null;
                }

                continue;
            }

            // Subsequent lines are part of the front matter until we hit the closing marker.
            if ($line === self::$frontMatterMarker) {
                break;
            }

            // For each successive line, append it to the front matter string.
            $frontMatterYamlString .= $line;
        }

        fclose($handle);

        if ($frontMatterYamlString === "") {
            return null;
        }

        return Yaml::parse($frontMatterYamlString);
    }

    private static function isValidSlug(string $slug): bool {
        return preg_match('/^[a-z0-9-]+$/', $slug) === 1;
    }

    private static function markdownConverter(): MarkdownConverter {
        $environment = new Environment();

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        return new MarkdownConverter($environment);
    }
}