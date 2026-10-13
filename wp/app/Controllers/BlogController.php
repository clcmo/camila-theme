<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\Article;

/** Lista do blog (home.php / index.php / arquivos). */
final class BlogController extends Controller
{
    public function index(): void
    {
        global $wp_query;
        $title = is_home() && ($id = (int) get_option('page_for_posts')) ? get_the_title($id) : get_the_archive_title();
        $this->render('pages/blog', [
            'title'      => $title ?: 'Blog',
            'articles'   => Article::fromMainQuery(),
            'pagination' => paginate_links([
                'total' => (int) $wp_query->max_num_pages, 'current' => max(1, (int) get_query_var('paged')),
                'type' => 'array', 'prev_next' => false,
            ]) ?: [],
            'nextUrl'    => get_next_posts_page_link(),
            'bodyClass' => 'pg-blog',
        ]);
    }
}
