---
title: Hello, world! This is the example post
subtitle: A tour of what this blog engine can do
written: 2026-08-09
updated: 2026-08-13
---

If you're reading this on your live site, the engine is working! Basic Markdown should work here, including **bold** text, _italic_ text, `inline code`, and [links](https://example.com).

If you're reading this on someone else's live site, they haven't made any posts yet. This website is probably under construction; best not to stick around.

This post lives in `example-posts/`, and is not meant to be a permanent part of the blog. Your own posts will go under `posts/` as `*.md` files. Once you create your first post under `posts/`, this example post will no longer be visible or accessible, so you can safely keep it around for reference without worrying about it being seen by visitors.

## How it works

Posts are Markdown files with a YAML front matter header:

```markdown
---
title: My first post
subtitle: A short description of what this post is about
written: 2026-08-10
updated: 2026-08-10
reviewers: [Alex, Sam]
---

Hello, world! This is my first post. Markdown is _nice_.
```

These are rendered by a custom PHP engine based on the League\CommonMark library with a few custom extensions. This engine supports:

- Syntax highlighting for code blocks with color-coded language labels
- Optional color-coding of inline code snippets based on the language
- Smart punctuation, including curly quotes, em dashes, and ellipses

Once rendered, the resulting HTML is cached for faster subsequent requests. The cache is automatically invalidated when the source Markdown file is updated.

## How to add your first post

Any new post you create under `posts/` will automatically appear on the index page, and will be accessible at `/blog/` plus the filename of the post (without the `.md` extension). For example, if you create a file called `my-first-post.md`, it will be accessible at `/blog/my-first-post`.

Posts can be marked as drafts by adding `draft: true` to the front matter. Draft posts will not appear on the index page, and will only be accessible to those with a direct link. This is useful for previewing your post and sharing it with a reviewer before it's ready for publication.

### Front matter fields

`title` is the title of the post, as displayed on the index page and at the top of the post itself. This will not dictate the URL of the post; that is determined by the filename.

`subtitle` is a short description of the post, also displayed on both the index page and at the top of the post itself. This is optional but recommended.

`written` is the date the post was written, in YYYY-MM-DD format. You may interpret "written" loosely; "started writing" or "published" are both reasonable interpretations. This is required unless `draft` is `true`.

`updated` is the date the post was last updated, in YYYY-MM-DD format. This is optional; if not provided, it will not be shown anywhere.

`reviewers` is a list of names of people who have reviewed the post. This is optional; if not provided, it will not be shown anywhere. It is recommended to send your posts for review for feedback before publishing, and it is recommended to thank them for it because that's a nice thing to do.

`draft` is a boolean indicating whether the post is a draft. Draft posts will not appear on the index page and will only be accessible to those with a direct link. This is optional; if not provided, it defaults to `false`.

## Code blocks, inline code, and syntax highlighting

This engine is optimized for programming polyglots, so it has a few features that make it easier to read code across multiple languages.

Fenced code blocks get not only syntax highlighting, but also a color-coded label indicating the language. For example, this is a JavaScript code block:

```js
function helloWorld() {
  console.log("Hello, world!");
}
```

...and this is a Python code block:

```py
def hello_world():
    print("Hello, world!")
```

Inline code can also be given a language color with pandoc-style attribute syntax. For example, `` `null`{.js} `` and `` `None`{.py} `` will be color-coded to match the language of the code block examples above: `null`{.js} and `None`{.py}. Great for language-comparison posts. Don't confuse C#'s `record`{.cs} with TypeScript's `Record`{.ts} - they are entirely different things!

Some languages don't have tokenizers, and will be rendered with a color-coded label but without syntax highlighting.

```cpp
#include <iostream>

int main() {
    std::cout << "Hello, World!" << std::endl;
    return 0;
}
```

Fences without a language tag will be rendered with a neutral gray label.

```
This is a code block with no language tag, so it has no syntax highlighting.
```

Languages without an associated color will be rendered with a dark gray label.

```VB6
MsgBox "Hello, world!"
```

## Tables

This blog engine supports GitHub Flavored Markdown tables. For example:

```markdown
| Language | Hello, world! |
|----------|----------------|
| JavaScript | `console.log("Hello, world!");`{.js} |
| Python | `print("Hello, world!")`{.py} |
| C++ | `std::cout << "Hello, World!" << std::endl;`{.cpp} |
| VB6 | `MsgBox "Hello, world!"` |
```

| Language | Hello, world! |
|----------|----------------|
| JavaScript | `console.log("Hello, world!");`{.js} |
| Python | `print("Hello, world!")`{.py} |
| C++ | `std::cout << "Hello, World!" << std::endl;`{.cpp} |
| VB6 | `MsgBox "Hello, world!"` |

Tables get more horizontal room than the main content area, so they can be wider than the rest of the post.

| &nbsp; | JavaScript | Python | C++ | VB6 |
|----------|------------|--------|-----|----------|
| Implementation | Interpreted + JIT | Compiled and interpreted | Compiled to native | Compiled to native or P-code |
| Paradigms | Procedural, functional, OO | Procedural, OO | Procedural, OO | Procedural, object-based |
| Is taken seriously | Yes | Yes | Yes | Uhhhhh |

Tables also become horizontally scrollable on small screens, so they don't break the layout.

## Summary

That's it! You can now create your first post under `posts/` and it will automatically appear on the index page. Remember to use the front matter fields to provide metadata about your post, and take advantage of the syntax highlighting and language labeling features for any code you include. GLHF!
