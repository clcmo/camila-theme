<?php /** @var array $article */ ?>
<article class="linha">
  <div class="linha__texto">
    <h2 class="linha__titulo"><a href="<?php echo esc_url($article['url']); ?>"><?php echo esc_html($article['title']); ?></a></h2>
    <span class="linha__seta" aria-hidden="true">↗</span>
  </div>
  <?php if ($article['thumb']) : ?>
    <a class="linha__imagem" href="<?php echo esc_url($article['url']); ?>" tabindex="-1" aria-hidden="true">
      <img src="<?php echo esc_url($article['thumb']); ?>" alt="" loading="lazy">
    </a>
  <?php else : ?>
    <span class="linha__imagem linha__imagem--vazia" aria-hidden="true"><i class="monograma" style="--mascara:url(<?php echo esc_url(CLO_URI . '/assets/img/monograma-ca.svg'); ?>)"></i></span>
  <?php endif; ?>
</article>
