<?php /** @var string $title @var string $thumb @var string $content */ ?>
<article class="texto-completo">
  <h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
  <?php if ($thumb) : ?><figure class="texto-completo__foto texto-completo__foto--larga"><img src="<?php echo esc_url($thumb); ?>" alt=""></figure><?php endif; ?>
  <div class="prosa"><?php echo wp_kses_post($content); ?></div>
</article>
