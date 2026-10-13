<?php /** @var array $video */ ?>
<li class="video">
  <div class="video__quadro" data-embed="<?php echo esc_url($video['embed']); ?>">
    <?php if ($video['thumb']) : ?><img src="<?php echo esc_url($video['thumb']); ?>" alt="" loading="lazy"><?php endif; ?>
    <?php if ($video['embed']) : ?>
      <button class="video__botao" type="button" aria-label="Assistir: <?php echo esc_attr($video['title']); ?>">
        <svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M8 5.5v13l11-6.5z" fill="currentColor"/></svg>
      </button>
    <?php endif; ?>
  </div>
  <h3 class="video__titulo"><?php echo esc_html($video['title']); ?></h3>
</li>
