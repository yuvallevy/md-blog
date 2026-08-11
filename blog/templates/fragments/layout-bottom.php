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
