<?php
namespace CamilaOliveira\Core;

/** Autoload PSR-4 simples: CamilaOliveira\Models\Book => app/Models/Book.php */
final class Autoloader
{
    public static function register(string $baseDir): void
    {
        spl_autoload_register(static function (string $class) use ($baseDir): void {
            $prefix = 'CamilaOliveira\\';
            if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
                return;
            }
            $file = $baseDir . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
            if (is_readable($file)) {
                require_once $file;
            }
        });
    }
}
