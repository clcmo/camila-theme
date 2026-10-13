<?php use CamilaOliveira\Core\View; /** @var string $title @var array $videos @var string $channelUrl */ ?>
<h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
<?php if ($channelUrl) : ?><p class="introducao"><a class="link-forte" href="<?php echo esc_url($channelUrl); ?>" target="_blank" rel="noopener">Ver o canal completo no YouTube ↗</a></p><?php endif; ?>
<ul class="videos videos--pagina">
  <?php foreach ($videos as $video) { View::render('partials/video-card', ['video' => $video]); } ?>
</ul>
<?php if (!$videos) : ?><p class="vazio">Os vídeos aparecem aqui assim que forem cadastrados no painel.</p><?php endif; ?>
