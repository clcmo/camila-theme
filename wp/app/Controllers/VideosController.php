<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;
use CamilaOliveira\Models\Video;

final class VideosController extends Controller
{
    public function index(): void
    {
        $this->render('pages/videos', [
            'title'      => get_the_title(),
            'videos'     => Video::latest(24),
            'channelUrl' => CustomizerController::get('clo_youtube_channel'),
            'bodyClass' => 'pg-videos',
        ]);
    }
}
