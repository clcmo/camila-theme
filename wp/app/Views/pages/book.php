<?php /** @var array $book @var string $content */ ?>
<article class="livro-pagina">
  <?php if ($book['cover']) : ?><img class="livro-pagina__capa" src="<?php echo esc_url($book['cover']); ?>" alt="Capa de <?php echo esc_attr($book['title']); ?>"><?php endif; ?>
  <div>
    <h1 class="titulo-pagina"><?php echo esc_html($book['title']); ?></h1>
    <p class="livro__meta"><?php echo esc_html(implode(', ', array_filter([$book['house'], $book['year']]))); ?></p>
    <div class="prosa"><?php echo wp_kses_post($content); ?></div>
    <?php if ($book['buy']) : ?>
      <h2 class="colecao__titulo">Onde comprar</h2>
      <ul class="compra">
        <?php foreach ($book['buy'] as $link) : ?>
          <li><a class="botao-contorno" href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($link['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</article>
