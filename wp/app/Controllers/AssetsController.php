<?php
namespace CamilaOliveira\Controllers;

final class AssetsController
{
    public static function init(): void
    {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueueAdmin']);
    }

    public static function enqueue(): void
    {
        wp_enqueue_style(
            'clo-fonts',
            'https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,400;0,7..72,600;1,7..72,400&family=Outfit:wght@500;700&display=swap',
            [], null
        );
        wp_enqueue_style('clo-theme', CLO_URI . '/assets/css/theme.css', ['clo-fonts'], CLO_VERSION);

        if (is_front_page() || is_page('livros') || is_singular('livro')) {
            self::enqueueModule('home');
        }
        if (is_front_page() || is_page(['videos', 'sons']) || is_singular(['video', 'som'])) {
            self::enqueueModule('media');
        }
        if (is_home() || is_archive() || is_search()) {
            self::enqueueModule('blog');
        }
        if (is_page('contato')) {
            self::enqueueModule('forms');
        }
        if (is_singular('product')) {
            self::enqueueModule('product');
        }
        if (function_exists('is_shop') && (is_shop() || (function_exists('is_product_taxonomy') && is_product_taxonomy()))) {
            self::enqueueModule('shop');
        }

        wp_enqueue_script('clo-theme', CLO_URI . '/assets/js/theme.js', [], CLO_VERSION, ['in_footer' => true, 'strategy' => 'defer']);
    }

    private static function enqueueModule(string $module): void
    {
        wp_enqueue_style(
            'clo-' . $module,
            CLO_URI . '/assets/css/' . $module . '.css',
            ['clo-theme'],
            CLO_VERSION
        );
    }

    public static function enqueueAdmin(string $hook): void
    {
        if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_script('clo-admin', CLO_URI . '/assets/js/admin.js', ['jquery'], CLO_VERSION, true);
    }
}
