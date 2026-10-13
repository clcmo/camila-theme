<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\Sound;

final class SoundsController extends Controller
{
    public function index(): void
    {
        $this->render('pages/sounds', [
            'title'     => get_the_title(),
            'sounds'    => Sound::latest(24),
            'bodyClass' => 'pg-sons',
        ]);
    }
}
