      <p id="blog-closer">
        For comments, questions, corrections, or other inquiries, please contact: <a href="mailto:<?= htmlspecialchars($config['authorEmail']) ?>"><?= htmlspecialchars($config['authorEmail']) ?></a>.
      </p>
    </main>

    <footer id="blog-footer">
      <?php if (isset($post)): ?>
        <a href="/blog">&larr; Back to index</a>
      <?php else: ?>
        <a href="/">&larr; <?= htmlspecialchars($config['homeLabel']) ?></a>
      <?php endif; ?>
    </footer>
  </body>
</html>
