<?php
use CamilaOliveira\Controllers\{CustomizerController, NewsletterController};
$code   = CustomizerController::get('clo_newsletter_code');
$status = NewsletterController::status();
?>
<section id="newsletter" class="newsletter" aria-labelledby="newsletter-titulo">
  <h2 id="newsletter-titulo"><?php echo esc_html(CustomizerController::get('clo_newsletter_title')); ?></h2>
  <?php if ($code !== '') : ?>
    <div class="newsletter__externo"><?php echo do_shortcode($code); ?></div>
  <?php else : ?>
    <form class="newsletter__form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <input type="hidden" name="action" value="clo_newsletter">
      <?php wp_nonce_field('clo_newsletter'); ?>
      <input class="armadilha" type="text" name="site" tabindex="-1" autocomplete="off" aria-hidden="true">
      <label class="sr" for="newsletter-email">E-mail</label>
      <input id="newsletter-email" type="email" name="email" placeholder="seu@email.com" required autocomplete="email">
      <button type="submit">Assinar</button>
    </form>
  <?php endif; ?>
  <?php if ($status) : ?><p class="newsletter__aviso" role="status"><?php echo esc_html($status); ?></p><?php endif; ?>
</section>
