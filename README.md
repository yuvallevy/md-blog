A simple PHP blog engine based on Markdown files. It is designed to be deployed to a simple shared hosting environment with Apache and PHP 8.3, with no build step, database, or long-running services required.

## Getting started with your own copy

This repo is a blank slate, meant as a template for you to add your own content to. Real content and site identity are gitignored, so a fresh clone runs with placeholder branding and a couple of example posts until you add your own.

The content is split across a couple of files that work the same way: a real one, gitignored, takes over completely the moment it exists; until then, the committed example is used. The table below shows which files are real vs example, and what they are used for:

| Real (gitignored)  | Committed fallback         | Used for                          |
|---------------------|-----------------------------|------------------------------------|
| `blog/posts/`        | `blog/example-posts/`       | Post content - see below           |
| `blog/config.php`    | `blog/config.example.php`   | Site title, author, index copy     |

To make the site your own, `cp blog/config.example.php blog/config.php` and edit the values inside, then add `.md` files to `blog/posts/` (the examples disappear automatically once any real posts exist). Both are already gitignored, so your real content and branding never accidentally end up in a commit meant for engine changes - and engine changes you make are still trackable normally, since only the two real directories above are ignored.

## Local preview

From inside `blog/`:

```
composer install
```

Then, from the repository root:

```
docker compose up
```

## Production build

Run this locally before uploading - Composer does not need to run on the server:

```
cd blog
composer install --no-dev --optimize-autoloader
```

### What to upload

The whole project, as-is, including `vendor/`:

- `theme.css` and any other HTML/JS/CSS files outside `blog/`
- `.htaccess` (repo root - this is what makes `/blog` and `/blog/{slug}` work; without it those URLs 404)
- `blog/` in full, including `vendor/`, `posts/`, `cache/` (can be uploaded empty - it self-populates), `composer.json`/`composer.lock`, and `config.php` if you created one (uploading without it just means the site runs with `config.example.php`'s placeholder branding)

Set the domain to **PHP 8.3**. If using cPanel, this can be done through the **MultiPHP Manager**. Nothing else needs configuring - no cron jobs, no database, no `.env`.

## Writing a post

Add a Markdown file to `blog/posts/`, named `your-slug.md` (this becomes the URL `/blog/your-slug`). Front matter:

```yaml
---
title: The title
subtitle: A subtitle, optional but recommended
written: 2026-08-04     # optional if draft: true, otherwise required
updated: 2026-08-10     # optional
reviewers: [Alex, Sam]  # optional
draft: true             # optional, defaults false
---
```

A post with `draft: true` will not show up on the `/blog` index but will still be accessible at its direct URL. This is useful for previewing a post before publishing or sending it to a reviewer. See `example-posts/draft-test.md` for a minimal example - visit `/blog/draft-test` directly, and confirm it does *not* appear on `/blog` (as long as `posts/` is still empty; once it has a real post, `example-posts/` stops being read - copy `draft-test.md` into `posts/` if you want to try this pattern with your real content).

Fenced code blocks are highlighted and given a labeled, color-coded frame automatically based on the fence's language tag. Inline code can be given a language color with pandoc-style attribute syntax: `` `function`{.js} `` - useful when comparing two languages inline.

## How rendering works

`blog/index.php` is the single entry point. It resolves `posts/` vs `example-posts/` (and `config.php` vs `config.example.php`) once at the top of the request, then hands the chosen posts directory to `Blog\PostRepository`.

`Blog\PostRepository` reads `*.md` from whichever directory it's given: the index page calls `listPublished`, which reads and parses only front matter, while a single post page calls `loadBySlug` which goes through the full `league/commonmark` pipeline in `Blog\MarkdownEnvironment`.

Once rendered, each render result is cached under `blog/cache/{slug}.html`. On the next request, if that cache file is newer than the source `.md`, it's served as-is; otherwise it's re-rendered. The cache directory is always safe to delete, as it regenerates on the next hit to each post.

### Code highlighting

Fenced code blocks are rendered by `Blog\FencedCodeRenderer`, which uses Tempest to tokenize and colorize the code, and wraps it in a labeled frame with a color matching the language. The label is derived from the fence's language tag, which is mapped to a canonical language name and color in `Blog\Languages`. Not every language has a tokenizer behind it, but all languages in the palette get the right label and color.

Inline code is rendered separately through a combination of `AttributesExtension` and CSS color classes in `blog/assets/blog.css`. This does not use Tempest.

## Security notes

- `blog/index.php` only accepts slugs that match the regex `/^[a-z0-9-]+$/` when lowercased. Path traversal and arbitrary file access are not possible.
- Markdown is rendered using the default Commonmark configuration, which disables raw HTML and unsafe links. The only HTML allowed is what the Markdown parser itself generates.
