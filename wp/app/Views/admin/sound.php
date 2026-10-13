<?php /** @var array $values */ ?>
<p><label for="_som_url"><strong>Arquivo de áudio</strong></label><br>
<input type="url" id="_som_url" name="_som_url" value="<?php echo esc_attr($values['_som_url']); ?>" class="large-text">
<button type="button" class="button" data-clo-midia="_som_url">Escolher na biblioteca</button></p>
<p><label for="_som_duracao"><strong>Duração</strong></label><br>
<input type="text" id="_som_duracao" name="_som_duracao" value="<?php echo esc_attr($values['_som_duracao']); ?>" class="small-text" placeholder="3:20"></p>
