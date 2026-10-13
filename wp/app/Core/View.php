<?php
namespace CamilaOliveira\Core;

/** Renderiza templates de app/Views. Views nunca consultam o banco: só recebem dados. */
final class View
{
    public static function render(string $view, array $data = []): void
    {
        echo self::capture($view, $data);
    }

    public static function capture(string $view, array $data = []): string
    {
        $file = CLO_DIR . '/app/Views/' . ltrim($view, '/') . '.php';
        if (!is_readable($file)) {
            return '';
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return (string) ob_get_clean();
    }
}
