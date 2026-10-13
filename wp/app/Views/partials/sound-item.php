<?php /** @var array $sound */ ?>
<li class="som" data-som>
  <button class="som__botao" type="button" aria-label="Tocar: <?php echo esc_attr($sound['title']); ?>" aria-pressed="false">
    <svg class="icone-play" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M8 5.5v13l11-6.5z" fill="currentColor"/></svg>
    <svg class="icone-pausa" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M7 5h4v14H7zm6 0h4v14h-4z" fill="currentColor"/></svg>
  </button>
  <div class="som__info">
    <h3 class="som__titulo"><?php echo esc_html($sound['title']); ?></h3>
    <?php if ($sound['excerpt']) : ?><p class="som__descricao"><?php echo esc_html($sound['excerpt']); ?></p><?php endif; ?>
    <div class="som__barra" role="progressbar" aria-label="Progresso" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><i></i></div>
  </div>
  <span class="som__tempo"><?php echo esc_html($sound['duration']); ?></span>
  <audio preload="none" src="<?php echo esc_url($sound['src']); ?>"></audio>
</li>
