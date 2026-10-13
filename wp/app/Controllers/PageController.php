<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;

/** Páginas comuns (Sobre, etc.). */
final class PageController extends Controller
{
    public function show(): void
    {
        the_post();
        $this->render('pages/page', [
            'title'     => get_the_title(),
            'thumb'     => get_the_post_thumbnail_url(null, 'full') ?: '',
            'content'   => apply_filters('the_content', get_the_content()),
            'bodyClass' => 'pg-pagina',
        ]);
    }
}
