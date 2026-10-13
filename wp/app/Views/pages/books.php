<?php use CamilaOliveira\Core\View; /** @var string $title @var string $intro @var array $groups */ ?>
<h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
<?php if ($intro) : ?><p class="introducao"><?php echo esc_html($intro); ?></p><?php endif; ?>
<?php foreach ($groups as $group) : ?>
  <section class="colecao" aria-labelledby="c-<?php echo esc_attr($group['slug']); ?>">
    <h2 class="colecao__titulo" id="c-<?php echo esc_attr($group['slug']); ?>"><?php echo esc_html($group['name']); ?></h2>
    <ul class="livros">
      <?php foreach ($group['books'] as $book) { View::render('partials/book-card', ['book' => $book]); } ?>
    </ul>
  </section>
<?php endforeach; ?>
<?php if (!$groups) : ?><p class="vazio">Os livros aparecem aqui assim que forem cadastrados no painel.</p><?php endif; ?>
