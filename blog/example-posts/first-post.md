---
title: Hello, world! This is the example post
subtitle: A tour of what this blog engine can do, for anyone setting up their own copy
written: 2026-08-09
updated: 2026-08-10
reviewers: [Alex, Sam]
---

If you're reading this in a browser, the engine is working. If you're reading the raw file, you're looking at `example-posts/first-post.md` - source for everything below, front matter, code blocks, and all.

This lives in `example-posts/`, not `posts/`: it's only shown while `posts/` is empty. The moment you add your own first `.md` file to `posts/`, this whole directory stops being read and your real posts take over completely - nothing to delete, nothing to remember. Come back and reread it whenever you need a reference for what this engine can do.

## How it works

Every post is a Markdown file with a little YAML front matter on top, sitting in `posts/` (or, for this one, `example-posts/`). There's no database and no admin panel - you write a file, upload it, and it shows up at a pretty URL. A small render cache keeps repeated requests from re-parsing the same file over and over, but it's dead simple: delete the `cache/` directory at any time and everything regenerates on the next request.

The router itself is short. This handles both `/blog` and `/blog/{slug}`:

```php
$slug = $_GET['slug'] ?? null;

if ($slug === null) {
    $postMetadataList = $repository->listPublished();
    require __DIR__ . '/templates/post-list.php';
    return;
}

$post = $repository->loadBySlug(is_string($slug) ? $slug : '');

if ($post === null) {
    http_response_code(404);
    require __DIR__ . '/templates/404.php';
    return;
}
```

## Code blocks get a little frame

Fenced code blocks go through a custom renderer that labels the language and colors the label to match, on top of real tokenized highlighting where a grammar exists for the language:

```python
def slugify(title):
    slug = title.lower()
    slug = re.sub(r'[^a-z0-9]+', '-', slug)
    return slug.strip('-')
```

Not every language in the color palette has a tokenizer behind it, though. TypeScript is one of them here - the block below still gets the right label and the right color, it just isn't token-colored line by line:

```ts
interface Post {
  title: string;
  written: Date;
  draft?: boolean;
}
```

If your favorite language shows up looking plain like that, it just means nobody's wired up a grammar for it yet in the highlighter this engine uses - the label and color still work regardless, and the block is still perfectly readable.

Fences without a language tag are rendered in a plain frame with no label, and are not token-colored:

```
This is a plain fence with no language tag. It gets a frame, but no label and no token coloring. It is still rendered as a code block, though, so it preserves whitespace and line breaks, and is still monospaced.
```

## Inline language colors

Sometimes a single word needs a color, not a whole block. Different languages spell the same idea differently, and reading it inline in two colors makes the comparison land faster than a whole second fenced block would: JavaScript calls it `null`{.js}, Python calls it `None`{.py} - same concept, two names, one line. Great for language-comparison posts.

## Summary

That's the feature set this post exists to demonstrate: front matter with every field, a tokenized block, an untokenized block, and inline language color. Write your own post the same way, and you're off. GLHF!
