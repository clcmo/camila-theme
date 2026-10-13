<?php /** @var array $values */ ?>
<p><label for="_livro_ano"><strong>Ano</strong></label><br><input type="text" id="_livro_ano" name="_livro_ano" value="<?php echo esc_attr($values['_livro_ano']); ?>" class="small-text"></p>
<p><label for="_livro_editora"><strong>Editora ou projeto</strong></label><br><input type="text" id="_livro_editora" name="_livro_editora" value="<?php echo esc_attr($values['_livro_editora']); ?>" class="regular-text"></p>
<p><label for="_livro_compra"><strong>Onde comprar</strong></label><br>
<textarea id="_livro_compra" name="_livro_compra" rows="4" class="large-text" placeholder="Amazon | https://...&#10;Editora | https://..."><?php echo esc_textarea($values['_livro_compra']); ?></textarea><br>
<span class="description">Uma loja por linha, no formato <code>Nome | endereço</code>.</span></p>
<p class="description">Dica: a capa é a imagem destacada do livro, e a coleção (Ficção, Não ficção…) é escolhida na lateral.</p>
