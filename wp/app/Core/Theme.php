<?php
namespace CamilaOliveira\Core;

use CamilaOliveira\Controllers\{AssetsController, SetupController, CustomizerController, AdminController, NewsletterController, ContactController, WooCommerceController};
use CamilaOliveira\Models\{Book, Video, Sound};

/** Liga Models e Controllers aos hooks do WordPress. */
final class Theme
{
    public static function boot(): void
    {
        // Models: tipos de conteúdo próprios
        add_action('init', [Book::class, 'register']);
        add_action('init', [Video::class, 'register']);
        add_action('init', [Sound::class, 'register']);

        // Controllers: comportamento
        SetupController::init();
        AssetsController::init();
        CustomizerController::init();
        AdminController::init();
        WooCommerceController::init();
        NewsletterController::init();
        ContactController::init();
    }
}
