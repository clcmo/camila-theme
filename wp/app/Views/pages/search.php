<?php use CamilaOliveira\Core\View; /** @var string $query @var array $articles */ ?>
<h1 class="titulo-pagina">Busca: <?php echo esc_html($query); ?></h1>
<div class="lista-linhas">
  <?php foreach ($articles as $article) { View::render('partials/article-row', ['article' => $article]); } ?>
  <?php if (!$articles) : ?><p class="vazio">Nada encontrado para “<?php echo esc_html($query); ?>”. Tente outra palavra.</p><?php endif; ?>
</div>
