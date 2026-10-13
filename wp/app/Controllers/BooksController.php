<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\Book;

final class BooksController extends Controller
{
    /** Página "Livros": curadoria por coleção, com onde comprar. */
    public function index(): void
    {
        $this->render('pages/books', [
            'title'     => get_the_title(),
            'intro'     => CustomizerController::get('clo_books_intro'),
            'groups'    => Book::grouped(),
            'bodyClass' => 'pg-livros',
        ]);
    }

    /** Livro individual. */
    public function show(): void
    {
        the_post();
        $this->render('pages/book', [
            'book'      => Book::map(get_post()),
            'content'   => apply_filters('the_content', get_the_content()),
            'bodyClass' => 'pg-livro',
        ]);
    }
}
