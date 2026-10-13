<?php $uid = wp_unique_id('busca-'); ?>
<form class="busca" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="sr" for="<?php echo esc_attr($uid); ?>">Pesquisar</label>
  <input id="<?php echo esc_attr($uid); ?>" type="search" name="s" placeholder="Pesquisar" value="<?php echo esc_attr(get_search_query()); ?>">
  <button type="submit" aria-label="Buscar"><svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6" fill="none" stroke="currentColor" stroke-width="2"/><path d="m15.5 15.5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
</form>
