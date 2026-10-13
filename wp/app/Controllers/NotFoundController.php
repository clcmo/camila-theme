<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;

final class NotFoundController extends Controller
{
    public function index(): void
    {
        status_header(404);
        $this->render('pages/not-found', ['bodyClass' => 'pg-404']);
    }
}
