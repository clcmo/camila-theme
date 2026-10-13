<?php
namespace CamilaOliveira\Core;

/** Os arquivos de template do WordPress só chamam Router::dispatch('Home'). */
final class Router
{
    public static function dispatch(string $controller, string $action = 'index'): void
    {
        $class = 'CamilaOliveira\\Controllers\\' . $controller . 'Controller';
        if (!class_exists($class) || !method_exists($class, $action)) {
            status_header(500);
            wp_die(esc_html("Controller inválido: {$controller}::{$action}"));
        }
        (new $class())->{$action}();
    }
}
