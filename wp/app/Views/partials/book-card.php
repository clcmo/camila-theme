<?php /** @var array $book */ ?>
<li class="livro">
  <a class="livro__capa" href="<?php echo esc_url($book['url']); ?>" tabindex="-1" aria-hidden="true">
    <?php if ($book['cover']) : ?><img src="<?php echo esc_url($book['cover']); ?>" alt="" loading="lazy"><?php endif; ?>
  </a>
  <h3 class="livro__titulo"><a href="<?php echo esc_url($book['url']); ?>"><?php echo esc_html($book['title']); ?></a></h3>
  <p class="livro__meta"><?php echo esc_html(implode(', ', array_filter([$book['house'], $book['year']]))); ?></p>
  <?php if ($book['buy']) : ?>
    <ul class="compra" aria-label="Onde comprar <?php echo esc_attr($book['title']); ?>">
      <?php foreach ($book['buy'] as $link) : ?>
        <li><a class="botao-contorno" href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($link['label']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</li>
