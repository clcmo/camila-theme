<?php /** @var string $title @var string $date @var string $dateIso @var string $thumb @var string $content @var bool $isProduct @var string $productPrice @var string $productShortDescription @var string $productSku @var array $productCategories @var array $productTags @var string $productPurchaseForm @var array $affiliateLinks */ ?>
<article class="texto-completo<?php echo $isProduct ? ' texto-completo--produto' : ' texto-completo--artigo'; ?>">
  <h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>

  <?php if ($isProduct) : ?>
    <?php $productTabsPrefix = 'produto-' . (int) get_the_ID(); ?>
    <?php $hasTechnicalInfo = $productSku || $productCategories || $productTags; ?>
    <section class="produto__resumo" aria-label="Resumo do produto">
      <?php if ($thumb) : ?>
        <figure class="produto__capa">
          <img src="<?php echo esc_url($thumb); ?>" alt="Capa de <?php echo esc_attr($title); ?>">
        </figure>
      <?php endif; ?>
      <div class="produto__painel">
        <?php if ($productShortDescription) : ?>
          <div class="prosa produto__descricao-curta"><?php echo wp_kses_post($productShortDescription); ?></div>
        <?php endif; ?>
        <?php if ($productPrice || $productPurchaseForm || $affiliateLinks) : ?>
          <div class="produto__compra" aria-label="Comprar produto">
            <?php if ($productPrice) : ?><div class="produto__preco"><?php echo wp_kses_post($productPrice); ?></div><?php endif; ?>
            <?php if ($productPurchaseForm) : ?><?php echo $productPurchaseForm; ?><?php endif; ?>
            <?php if ($affiliateLinks) : ?>
              <div class="produto__links-afiliados" aria-label="Links de compra">
                <?php foreach ($affiliateLinks as $affiliateLink) : ?>
                  <a class="produto__cta" href="<?php echo esc_url($affiliateLink['url']); ?>" target="_blank" rel="nofollow sponsored noopener"><?php echo esc_html($affiliateLink['label']); ?></a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>
      <div class="produto__abas" data-produto-abas>
        <div class="produto__abas-nav" role="tablist" aria-label="Informações do produto">
          <button class="produto__aba" id="<?php echo esc_attr($productTabsPrefix . '-tab-descricao'); ?>" type="button" role="tab" aria-selected="true" aria-controls="<?php echo esc_attr($productTabsPrefix . '-painel-descricao'); ?>">Descrição</button>
          <?php if ($hasTechnicalInfo) : ?>
            <button class="produto__aba" id="<?php echo esc_attr($productTabsPrefix . '-tab-tecnica'); ?>" type="button" role="tab" aria-selected="false" aria-controls="<?php echo esc_attr($productTabsPrefix . '-painel-tecnica'); ?>" tabindex="-1">Informações técnicas</button>
          <?php endif; ?>
        </div>
        <section class="produto__painel-abas" id="<?php echo esc_attr($productTabsPrefix . '-painel-descricao'); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($productTabsPrefix . '-tab-descricao'); ?>">
          <h2 class="sr">Descrição completa</h2>
          <div class="prosa produto__descricao-completa"><?php echo wp_kses_post($content); ?></div>
        </section>
        <?php if ($hasTechnicalInfo) : ?>
          <section class="produto__painel-abas" id="<?php echo esc_attr($productTabsPrefix . '-painel-tecnica'); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($productTabsPrefix . '-tab-tecnica'); ?>">
            <h2 class="sr">Informações técnicas</h2>
            <div class="produto__detalhes" aria-label="Detalhes do produto">
              <?php if ($productCategories) : ?>
                <div class="produto__grupo">
                  <span class="produto__rotulo">Categorias</span>
                  <?php foreach ($productCategories as $category) : ?>
                    <a class="produto__pill" href="<?php echo esc_url($category['url']); ?>"><?php echo esc_html($category['name']); ?></a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if ($productTags) : ?>
                <div class="produto__grupo">
                  <span class="produto__rotulo">Tags</span>
                  <?php foreach ($productTags as $tag) : ?>
                    <a class="produto__pill" href="<?php echo esc_url($tag['url']); ?>"><?php echo esc_html($tag['name']); ?></a>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if ($productSku) : ?>
                <div class="produto__grupo">
                  <span class="produto__rotulo">SKU</span>
                  <span class="produto__pill produto__pill--sku"><?php echo esc_html($productSku); ?></span>
                </div>
              <?php endif; ?>
            </div>
          </section>
        <?php endif; ?>
      </div>
  <?php else : ?>
    <?php if ($date) : ?>
      <p class="texto-completo__data">
        <time datetime="<?php echo esc_attr($dateIso); ?>"><?php echo esc_html($date); ?></time>
      </p>
    <?php endif; ?>
    <?php if ($thumb) : ?>
      <figure class="texto-completo__foto"><img src="<?php echo esc_url($thumb); ?>" alt=""></figure>
    <?php endif; ?>
    <div class="prosa"><?php echo wp_kses_post($content); ?></div>
  <?php endif; ?>
</article>