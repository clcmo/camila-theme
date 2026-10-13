<?php
/**
 * Camila L. Oliveira — bootstrap do tema.
 * Aqui só se registra o autoload e se inicializam os Controllers.
 * Regras de negócio ficam em app/Models, lógica de requisição em app/Controllers
 * e HTML em app/Views.
 */
defined('ABSPATH') || exit;

define('CLO_VERSION', '1.0.4');
define('CLO_DIR', get_template_directory());
define('CLO_URI', get_template_directory_uri());

require_once CLO_DIR . '/app/Core/Autoloader.php';
\CamilaOliveira\Core\Autoloader::register(CLO_DIR . '/app');

\CamilaOliveira\Core\Theme::boot();
