<?php
namespace CamilaOliveira\Core;

use CamilaOliveira\Models\Menu;

abstract class Controller
{
    /** Monta layout (cabeçalho + view + rodapé) com os dados comuns a todas as páginas. */
    protected function render(string $view, array $data = []): void
    {
        $data += [
            'bodyClass' => '',
            'isHome'    => false,
            'menu'      => Menu::primary(),
            'siteName'  => get_bloginfo('name'),
        ];
        View::render('layouts/header', $data);
        View::render($view, $data);
        View::render('layouts/footer', $data);
    }
}
