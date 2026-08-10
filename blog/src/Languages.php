<?php

declare(strict_types=1);

namespace Blog;

final class Languages {
    private const array LANGUAGE_MAP = [
        'typescript' =>   ['brand' => '#3178C6', 'chipFg' => 'paper', 'text' => '#246AB5', 'name' => 'TypeScript'],
        'javascript' =>   ['brand' => '#F1E05A', 'chipFg' => 'ink',   'text' => '#796624', 'name' => 'JavaScript'],
        'c' =>            ['brand' => '#555555', 'chipFg' => 'paper', 'text' => '#555555', 'name' => 'C'],
        'cpp' =>          ['brand' => '#F34B7D', 'chipFg' => 'paper', 'text' => '#BA2451', 'name' => 'C++'],
        'csharp' =>       ['brand' => '#178600', 'chipFg' => 'paper', 'text' => '#026B00', 'name' => 'C#'],
        'fsharp' =>       ['brand' => '#B845FC', 'chipFg' => 'ink',   'text' => '#A218F5', 'name' => 'F#'],
        'kotlin' =>       ['brand' => '#A97BFF', 'chipFg' => 'ink',   'text' => '#724ABA', 'name' => 'Kotlin'],
        'haskell' =>      ['brand' => '#5E5086', 'chipFg' => 'ink',   'text' => '#4A3B7A', 'name' => 'Haskell'],
        'ocaml' =>        ['brand' => '#3BE133', 'chipFg' => 'ink',   'text' => '#307A0E', 'name' => 'OCaml'],
        'swift' =>        ['brand' => '#FFAC45', 'chipFg' => 'ink',   'text' => '#B35700', 'name' => 'Swift'],
        'python' =>       ['brand' => '#3572A5', 'chipFg' => 'paper', 'text' => '#444EB8', 'name' => 'Python'],
        'rust' =>         ['brand' => '#DEA584', 'chipFg' => 'ink',   'text' => '#855D45', 'name' => 'Rust'],
        'go' =>           ['brand' => '#00ADD8', 'chipFg' => 'ink',   'text' => '#006E91', 'name' => 'Go'],
        'java' =>         ['brand' => '#9E6717', 'chipFg' => 'paper', 'text' => '#915814', 'name' => 'Java'],
        'php' =>          ['brand' => '#4F5D95', 'chipFg' => 'paper', 'text' => '#4F5D95', 'name' => 'PHP'],
        'html' =>         ['brand' => '#CC4422', 'chipFg' => 'paper', 'text' => '#B53A1B', 'name' => 'HTML'],
        'css' =>          ['brand' => '#663399', 'chipFg' => 'paper', 'text' => '#663399', 'name' => 'CSS'],
        'ruby' =>         ['brand' => '#701516', 'chipFg' => 'paper', 'text' => '#701516', 'name' => 'Ruby'],
    ];

    private const array ALIASES = [
        'ts' => 'typescript',
        'js' => 'javascript',
        'node' => 'javascript',
        'c++' => 'cpp',
        'cplusplus' => 'cpp',
        'cs' => 'csharp',
        'c#' => 'csharp',
        'fs' => 'fsharp',
        'f#' => 'fsharp',
        'kt' => 'kotlin',
        'py' => 'python',
        'rs' => 'rust',
        'golang' => 'go',
        'rb' => 'ruby',
    ];

    public static function get(string $slug): array {
        $slug = self::ALIASES[$slug] ?? $slug;
        $entry = self::LANGUAGE_MAP[$slug] ?? null;

        if ($entry === null) {
            return [
                'slug' => $slug,
                'name' => $slug === '' ? 'Text' : ucfirst($slug),
                'brand' => '#8C7A71',  // ink-faint
                'chipFg' => 'paper',
                'text' => '#241A18',  // ink
            ];
        }

        return ['slug' => $slug, ...$entry];
    }
}
