<?php
namespace CamilaOliveira\Controllers;

final class SetupController
{
    public static function init(): void
    {
        add_action('after_setup_theme', [self::class, 'setup']);
        add_filter('excerpt_length', static fn() => 28);
        add_filter('excerpt_more', static fn() => '…');
    }

    public static function setup(): void
    {
        load_theme_textdomain('camila-oliveira', CLO_DIR . '/languages');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('woocommerce');
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
        add_theme_support('responsive-embeds');
        add_theme_support('custom-logo', ['height' => 120, 'width' => 120, 'flex-width' => true, 'flex-height' => true]);
        register_nav_menus(['principal' => 'Menu principal']);
        add_image_size('capa-livro', 640, 900, false);
        add_image_size('linha-blog', 700, 400, true);
    }
}
