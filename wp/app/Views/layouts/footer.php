<?php /** @var array $menu @var string $siteName */ ?>
</main>

<footer class="rodape">
  <div class="rodape__nav">
    <nav aria-label="Menu do rodapé">
      <ul>
        <?php foreach ($menu as $item) : ?>
          <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php \CamilaOliveira\Core\View::render('partials/search-form'); ?>
  </div>
  <?php \CamilaOliveira\Core\View::render('partials/brand', ['class' => 'marca--rodape', 'tag' => 'p']); ?>
  <p class="rodape__copy">© <?php echo esc_html(wp_date('Y')); ?>. <?php echo esc_html($siteName); ?>. Todos os direitos reservados.</p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
