<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\Article;

final class SearchController extends Controller
{
    public function index(): void
    {
        $this->render('pages/search', [
            'query'     => get_search_query(),
            'articles'  => Article::fromMainQuery(),
            'bodyClass' => 'pg-busca',
        ]);
    }
}
