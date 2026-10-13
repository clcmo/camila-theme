<?php use CamilaOliveira\Core\View; /** @var string $title @var array $articles @var array $pagination @var string $nextUrl */ ?>
<h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
<div class="lista-linhas">
  <?php foreach ($articles as $article) { View::render('partials/article-row', ['article' => $article]); } ?>
  <?php if (!$articles) : ?><p class="vazio">Ainda não há textos por aqui.</p><?php endif; ?>
</div>
<?php if ($pagination) : ?>
  <nav class="paginacao" aria-label="Paginação">
    <?php foreach ($pagination as $link) { echo wp_kses_post($link); } ?>
    <?php if ($nextUrl) : ?><a class="paginacao__proxima" href="<?php echo esc_url($nextUrl); ?>">Próxima página »</a><?php endif; ?>
  </nav>
<?php endif; ?>
