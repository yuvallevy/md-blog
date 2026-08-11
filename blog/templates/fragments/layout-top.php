<?php
/**
 * @var string $pageTitle
 * @var string|null $pageDescription
 * @var array{siteTitle: string, authorName: string, homeLabel: string, indexEyebrow: string, indexHeading: string} $config
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
    <meta name="author" content="<?= htmlspecialchars($config['authorName']) ?>" />
    <meta name="generator" content="<?= htmlspecialchars($config['siteTitle']) ?>" />
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
    <meta property="og:site_name" content="<?= htmlspecialchars($config['siteTitle']) ?>" />
    <link rel="stylesheet" href="/theme.css" />
    <link rel="stylesheet" href="/blog/assets/blog.css" />
  </head>

  <body>
    <header id="blog-header">
      <a href="/blog" id="blog-title-link"><?= htmlspecialchars($config['siteTitle']) ?></a>
    </header>

    <main id="blog-main">
