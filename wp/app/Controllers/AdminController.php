<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\View;
use CamilaOliveira\Models\{Book, Video, Sound};

/** Caixas de edição (metaboxes) dos livros, vídeos e sons. */
final class AdminController
{
    private const NONCE = 'clo_meta_nonce';

    /** tipo => [meta => sanitizador] */
    private const FIELDS = [
        Book::TYPE  => ['_livro_ano' => 'sanitize_text_field', '_livro_editora' => 'sanitize_text_field', '_livro_compra' => 'sanitize_textarea_field'],
        Video::TYPE => ['_video_youtube' => 'esc_url_raw'],
        Sound::TYPE => ['_som_url' => 'esc_url_raw', '_som_duracao' => 'sanitize_text_field'],
    ];

    public static function init(): void
    {
        add_action('add_meta_boxes', [self::class, 'boxes']);
        add_action('save_post', [self::class, 'save']);
    }

    public static function boxes(): void
    {
        add_meta_box('clo_livro', 'Dados do livro', [self::class, 'bookBox'], Book::TYPE, 'normal', 'high');
        add_meta_box('clo_video', 'Vídeo do YouTube', [self::class, 'videoBox'], Video::TYPE, 'normal', 'high');
        add_meta_box('clo_som', 'Arquivo de áudio', [self::class, 'soundBox'], Sound::TYPE, 'normal', 'high');
    }

    public static function bookBox(\WP_Post $post): void  { self::box('admin/book', $post); }
    public static function videoBox(\WP_Post $post): void { self::box('admin/video', $post); }
    public static function soundBox(\WP_Post $post): void { self::box('admin/sound', $post); }

    private static function box(string $view, \WP_Post $post): void
    {
        wp_nonce_field(self::NONCE, self::NONCE);
        $values = [];
        foreach (self::FIELDS[$post->post_type] ?? [] as $key => $_) {
            $values[$key] = (string) get_post_meta($post->ID, $key, true);
        }
        View::render($view, ['values' => $values]);
    }

    public static function save(int $postId): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!isset($_POST[self::NONCE]) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[self::NONCE])), self::NONCE)) {
            return;
        }
        if (!current_user_can('edit_post', $postId)) {
            return;
        }
        $fields = self::FIELDS[get_post_type($postId)] ?? [];
        foreach ($fields as $key => $sanitize) {
            if (isset($_POST[$key])) {
                update_post_meta($postId, $key, $sanitize(wp_unslash($_POST[$key])));
            }
        }
    }
}
