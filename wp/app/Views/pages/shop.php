<?php /** @var string $title @var array $products @var int $foundProducts @var string $pagination */ ?>
<section class="loja" aria-labelledby="titulo-loja">
  <h1 class="titulo-pagina" id="titulo-loja"><?php echo esc_html($title); ?></h1>
  <div class="loja__toolbar">
    <p class="loja__resultado" aria-live="polite">
      <?php echo esc_html(sprintf(_n('%s produto', '%s produtos', $foundProducts, 'camila-oliveira'), number_format_i18n($foundProducts))); ?>
    </p>
    <?php do_action('woocommerce_before_shop_loop'); ?>
  </div>

  <?php if ($products) : ?>
    <ul class="loja__produtos">
      <?php foreach ($products as $product) : ?>
        <li class="loja__produto">
          <a class="loja__capa" href="<?php echo esc_url($product['url']); ?>" tabindex="-1" aria-hidden="true">
            <?php if ($product['image']) : ?><img src="<?php echo esc_url($product['image']); ?>" alt="" loading="lazy"><?php endif; ?>
          </a>
          <h2 class="loja__nome"><a href="<?php echo esc_url($product['url']); ?>"><?php echo esc_html($product['title']); ?></a></h2>
          <?php if ($product['price']) : ?><div class="loja__preco"><?php echo wp_kses_post($product['price']); ?></div><?php endif; ?>
          <a class="loja__cta" href="<?php echo esc_url($product['purchaseUrl']); ?>"<?php echo $product['isExternal'] ? ' target="_blank" rel="nofollow sponsored noopener"' : ''; ?>><?php echo esc_html($product['purchaseLabel']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p class="vazio">Nenhum produto encontrado.</p>
  <?php endif; ?>

  <?php if ($pagination) : ?><nav class="loja__paginacao" aria-label="Paginação dos produtos"><?php echo wp_kses_post($pagination); ?></nav><?php endif; ?>
</section>