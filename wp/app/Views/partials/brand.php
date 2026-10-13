<?php
/** Marca "Camila" em máscara CSS: aceita gradiente, brilho e animação. @var string $class @var string $tag */
$tag = $tag ?? 'p';
?>
<<?php echo tag_escape($tag); ?> class="marca <?php echo esc_attr($class ?? ''); ?>">
  <span class="marca__arte" aria-hidden="true" style="--mascara:url(<?php echo esc_url(CLO_URI . '/assets/img/marca-camila.svg'); ?>)"></span>
  <span class="marca__texto"><?php echo esc_html(get_bloginfo('name')); ?></span>
</<?php echo tag_escape($tag); ?>>
