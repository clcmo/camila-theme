<?php
namespace CamilaOliveira\Models;

/** Livros publicados: tipo de conteúdo "livro" + coleção (Ficção, Não ficção, Parcerias…). */
final class Book
{
    public const TYPE = 'livro';
    public const TAX  = 'colecao_livro';

    public static function register(): void
    {
        register_post_type(self::TYPE, [
            'labels' => [
                'name' => 'Livros', 'singular_name' => 'Livro', 'add_new_item' => 'Adicionar livro',
                'edit_item' => 'Editar livro', 'all_items' => 'Todos os livros',
            ],
            'public' => true, 'has_archive' => false, 'show_in_rest' => true,
            'menu_icon' => 'dashicons-book', 'menu_position' => 21,
            'rewrite' => ['slug' => 'livro'],
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        ]);

        register_taxonomy(self::TAX, self::TYPE, [
            'labels' => ['name' => 'Coleções', 'singular_name' => 'Coleção'],
            'hierarchical' => true, 'show_in_rest' => true, 'show_admin_column' => true,
            'rewrite' => ['slug' => 'colecao'],
        ]);

        foreach (['_livro_ano', '_livro_editora', '_livro_compra'] as $key) {
            register_post_meta(self::TYPE, $key, [
                'type' => 'string', 'single' => true, 'show_in_rest' => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => static fn() => current_user_can('edit_posts'),
            ]);
        }
    }

    /** @return array<int,array> */
    public static function all(int $limit = -1, ?string $collection = null): array
    {
        $args = [
            'post_type' => self::TYPE, 'posts_per_page' => $limit, 'no_found_rows' => true,
            'meta_query' => [
                'relation' => 'OR',
                'ano'      => ['key' => '_livro_ano', 'type' => 'NUMERIC', 'compare' => 'EXISTS'],
                'sem_ano'  => ['key' => '_livro_ano', 'compare' => 'NOT EXISTS'],
            ],
            'orderby' => ['ano' => 'DESC', 'title' => 'ASC'],
        ];
        if ($collection) {
            $args['tax_query'] = [['taxonomy' => self::TAX, 'field' => 'slug', 'terms' => $collection]];
        }
        return array_map([self::class, 'map'], get_posts($args));
    }

    /** Livros agrupados por coleção, na ordem definida no painel. @return array<int,array{name:string,slug:string,books:array}> */
    public static function grouped(): array
    {
        $groups = [];
        $terms = get_terms(['taxonomy' => self::TAX, 'hide_empty' => true, 'orderby' => 'term_order']);
        if (is_wp_error($terms)) {
            return [];
        }
        foreach ($terms as $term) {
            $groups[] = ['name' => $term->name, 'slug' => $term->slug, 'books' => self::all(-1, $term->slug)];
        }
        return $groups;
    }

    public static function map(\WP_Post $post): array
    {
        $id = $post->ID;
        return [
            'id'      => $id,
            'title'   => get_the_title($post),
            'url'     => get_permalink($post),
            'year'    => (string) get_post_meta($id, '_livro_ano', true),
            'house'   => (string) get_post_meta($id, '_livro_editora', true),
            'cover'   => get_the_post_thumbnail_url($post, 'large') ?: '',
            'excerpt' => get_the_excerpt($post),
            'buy'     => self::purchaseLinks($id),
        ];
    }

    /** Campo "Onde comprar": uma linha por loja no formato  Rótulo | URL  */
    public static function purchaseLinks(int $id): array
    {
        $links = [];
        foreach (preg_split('/\r\n|\r|\n/', (string) get_post_meta($id, '_livro_compra', true)) as $line) {
            [$label, $url] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');
            $url = esc_url_raw($url);
            if ($label !== '' && $url !== '') {
                $links[] = ['label' => $label, 'url' => $url];
            }
        }
        return $links;
    }
}
