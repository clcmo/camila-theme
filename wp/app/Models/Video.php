<?php
namespace CamilaOliveira\Models;

/** Vídeos do canal no YouTube. Guarda só o link; miniatura e player vêm do ID. */
final class Video
{
    public const TYPE = 'video';

    public static function register(): void
    {
        register_post_type(self::TYPE, [
            'labels' => ['name' => 'Vídeos', 'singular_name' => 'Vídeo', 'add_new_item' => 'Adicionar vídeo', 'all_items' => 'Todos os vídeos'],
            'public' => true, 'has_archive' => false, 'show_in_rest' => true,
            'menu_icon' => 'dashicons-video-alt3', 'menu_position' => 22,
            'rewrite' => ['slug' => 'video'],
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        ]);
        register_post_meta(self::TYPE, '_video_youtube', [
            'type' => 'string', 'single' => true, 'show_in_rest' => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback' => static fn() => current_user_can('edit_posts'),
        ]);
    }

    public static function latest(int $limit = 6): array
    {
        return array_map([self::class, 'map'], get_posts([
            'post_type' => self::TYPE, 'posts_per_page' => $limit, 'no_found_rows' => true,
        ]));
    }

    public static function youtubeId(string $url): string
    {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }
        return '';
    }

    public static function map(\WP_Post $post): array
    {
        $link = (string) get_post_meta($post->ID, '_video_youtube', true);
        $yid  = self::youtubeId($link);
        return [
            'id'      => $post->ID,
            'title'   => get_the_title($post),
            'excerpt' => get_the_excerpt($post),
            'youtube' => $link,
            'videoId' => $yid,
            'thumb'   => get_the_post_thumbnail_url($post, 'large') ?: ($yid ? "https://i.ytimg.com/vi/{$yid}/hqdefault.jpg" : ''),
            'embed'   => $yid ? "https://www.youtube-nocookie.com/embed/{$yid}?autoplay=1&rel=0" : '',
        ];
    }
}
