<?php use CamilaOliveira\Core\View; /** @var string $title @var array $sounds */ ?>
<h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
<ul class="sons sons--pagina">
  <?php foreach ($sounds as $sound) { View::render('partials/sound-item', ['sound' => $sound]); } ?>
</ul>
<?php if (!$sounds) : ?><p class="vazio">Os sons aparecem aqui assim que forem cadastrados no painel.</p><?php endif; ?>
