<?php
/**
 * @var string $pageTitle
 * @var string|null $pageDescription
 */
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <?php if (!empty($pageDescription)): ?>
      <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <?php endif; ?>
    <meta name="author" content="<?= htmlspecialchars(DEFAULT_AUTHOR) ?>" />
    <meta name="generator" content="yuvallevy.dev blog" />
    <meta name="robots" content="index, follow" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>" />
    <?php if (!empty($pageDescription)): ?>
      <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <?php endif; ?>
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>" />
    <?php if (!empty($pageDescription)): ?>
      <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>" />
    <?php endif; ?>
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="yuvallevy.dev blog" />
    <link rel="stylesheet" href="/theme.css" />
  </head>

  <body>
    <header>
      <a href="/blog">yuvallevy.dev blog</a>
    </header>
    <main>
