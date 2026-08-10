<?php
$pageTitle = 'Page not found - ' . SITE_TITLE;

require __DIR__ . '/fragments/layout-top.php';
?>

<section id="blog-404">
  <div class="eyebrow">404</div>
  <h1>Nothing at this address.</h1>
  <p>
    This post doesn&rsquo;t exist. It may have moved, or the link might be wrong.
    Either way, there&rsquo;s nothing to read here.
  </p>
  <p><a href="/blog">&larr; Back to the blog index</a></p>
</section>

<?php
require __DIR__ . '/fragments/layout-bottom.php';