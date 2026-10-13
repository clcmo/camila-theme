<?php
namespace CamilaOliveira\Models;

/** Sons: leituras, trilhas, episódios — qualquer áudio da biblioteca de mídia ou de um link direto. */
final class Sound
{
    public const TYPE = 'som';

    public static function register(): void
    {
        register_post_type(self::TYPE, [
            'labels' => ['name' => 'Sons', 'singular_name' => 'Som', 'add_new_item' => 'Adicionar som', 'all_items' => 'Todos os sons'],
            'public' => true, 'has_archive' => false, 'show_in_rest' => true,
            'menu_icon' => 'dashicons-format-audio', 'menu_position' => 23,
            'rewrite' => ['slug' => 'som'],
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        ]);
        register_post_meta(self::TYPE, '_som_url', [
            'type' => 'string', 'single' => true, 'show_in_rest' => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback' => static fn() => current_user_can('edit_posts'),
        ]);
        register_post_meta(self::TYPE, '_som_duracao', [
            'type' => 'string', 'single' => true, 'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => static fn() => current_user_can('edit_posts'),
        ]);
    }

    public static function latest(int $limit = 6): array
    {
        return array_map([self::class, 'map'], get_posts([
            'post_type' => self::TYPE, 'posts_per_page' => $limit, 'no_found_rows' => true,
        ]));
    }

    public static function map(\WP_Post $post): array
    {
        return [
            'id'       => $post->ID,
            'title'    => get_the_title($post),
            'excerpt'  => get_the_excerpt($post),
            'src'      => (string) get_post_meta($post->ID, '_som_url', true),
            'duration' => (string) get_post_meta($post->ID, '_som_duracao', true),
            'cover'    => get_the_post_thumbnail_url($post, 'medium') ?: '',
        ];
    }
}
