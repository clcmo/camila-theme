<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\{Book, Video, Sound};

final class HomeController extends Controller
{
    public function index(): void
    {
        $heroId = (int) get_theme_mod('clo_hero_image');
        $this->render('pages/home', [
            'isHome'     => true,
            'bodyClass' => 'pg-inicio',
            'heroUrl'    => $heroId ? (string) wp_get_attachment_image_url($heroId, 'full') : '',
            'heroAlt'    => CustomizerController::get('clo_hero_alt'),
            'books'      => Book::all(4),
            'videos'     => Video::latest(3),
            'sounds'     => Sound::latest(3),
            'channelUrl' => CustomizerController::get('clo_youtube_channel'),
            'booksUrl'   => home_url('/livros/'),
        ]);
    }
}
