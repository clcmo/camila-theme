<?php
use CamilaOliveira\Core\View;
/** @var string $heroUrl @var string $heroAlt @var array $books @var array $videos @var array $sounds @var string $channelUrl @var string $booksUrl */
?>
<section class="capa">
  <?php View::render('partials/brand', ['class' => 'marca--capa', 'tag' => 'h1']); ?>
  <?php if ($heroUrl) : ?>
    <figure class="capa__foto"><img src="<?php echo esc_url($heroUrl); ?>" alt="<?php echo esc_attr($heroAlt); ?>" fetchpriority="high"></figure>
  <?php endif; ?>
</section>

<?php View::render('partials/newsletter'); ?>

<?php if ($books) : ?>
<section class="vitrine" id="livros" aria-labelledby="t-livros">
  <header class="vitrine__cab">
    <h2 id="t-livros">Livros</h2>
    <a class="vitrine__ver" href="<?php echo esc_url($booksUrl); ?>">Ver todos <span aria-hidden="true">↗</span></a>
  </header>
  <ul class="livros">
    <?php foreach ($books as $book) { View::render('partials/book-card', ['book' => $book]); } ?>
  </ul>
</section>
<?php endif; ?>

<?php if ($videos) : ?>
<section class="vitrine" id="videos" aria-labelledby="t-videos">
  <header class="vitrine__cab">
    <h2 id="t-videos">Vídeos</h2>
    <?php if ($channelUrl) : ?><a class="vitrine__ver" href="<?php echo esc_url($channelUrl); ?>" target="_blank" rel="noopener">Canal no YouTube <span aria-hidden="true">↗</span></a><?php endif; ?>
  </header>
  <ul class="videos">
    <?php foreach ($videos as $video) { View::render('partials/video-card', ['video' => $video]); } ?>
  </ul>
</section>
<?php endif; ?>

<?php if ($sounds) : ?>
<section class="vitrine" id="sons" aria-labelledby="t-sons">
  <header class="vitrine__cab"><h2 id="t-sons">Sons</h2></header>
  <ul class="sons">
    <?php foreach ($sounds as $sound) { View::render('partials/sound-item', ['sound' => $sound]); } ?>
  </ul>
</section>
<?php endif; ?>
