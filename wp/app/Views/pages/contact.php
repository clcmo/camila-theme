<?php /** @var string $title @var string $intro @var string $message @var bool $ok */ ?>
<h1 class="titulo-pagina"><?php echo esc_html($title); ?></h1>
<div class="prosa"><?php echo wp_kses_post($intro); ?></div>
<?php if ($message) : ?><p class="aviso <?php echo $ok ? 'aviso--ok' : 'aviso--erro'; ?>" role="status"><?php echo esc_html($message); ?></p><?php endif; ?>
<form class="formulario" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
  <input type="hidden" name="action" value="clo_contact">
  <?php wp_nonce_field('clo_contact'); ?>
  <input class="armadilha" type="text" name="site" tabindex="-1" autocomplete="off" aria-hidden="true">
  <label for="c-nome">Nome</label>
  <input id="c-nome" name="nome" type="text" required autocomplete="name">
  <label for="c-email">E-mail</label>
  <input id="c-email" name="email" type="email" required autocomplete="email">
  <label for="c-mensagem">Mensagem</label>
  <textarea id="c-mensagem" name="mensagem" rows="6" required></textarea>
  <button class="botao" type="submit">Enviar</button>
</form>
