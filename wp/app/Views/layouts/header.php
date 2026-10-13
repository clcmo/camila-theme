<?php
/** @var array $menu @var bool $isHome @var string $bodyClass */
$img = CLO_URI . '/assets/img/';
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class($bodyClass); ?>>
<?php wp_body_open(); ?>
<a class="pular" href="#conteudo">Pular para o conteúdo</a>

<header class="topo">
  <a class="topo__marca" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($siteName); ?> — página inicial">
    <span class="monograma" role="img" aria-hidden="true" style="--mascara:url(<?php echo esc_url($img . 'monograma-ca.svg'); ?>)"></span>
  </a>
  <button class="topo__menu" type="button" aria-expanded="false" aria-controls="menu-principal">
    <span class="sr">Abrir menu</span><i aria-hidden="true"></i>
  </button>
  <nav id="menu-principal" class="menu" aria-label="Menu principal" hidden>
    <ul>
      <?php foreach ($menu as $item) : ?>
        <li><a href="<?php echo esc_url($item['url']); ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html($item['label']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>

<main id="conteudo" class="conteudo">
