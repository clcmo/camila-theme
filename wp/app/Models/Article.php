<?php
namespace CamilaOliveira\Models;

/** Textos do blog (posts nativos). */
final class Article
{
    public static function map(\WP_Post $post): array
    {
        return [
            'id'      => $post->ID,
            'title'   => get_the_title($post),
            'url'     => get_permalink($post),
            'thumb'   => get_the_post_thumbnail_url($post, 'large') ?: '',
            'date'    => get_the_date('', $post),
            'dateIso' => get_the_date('c', $post),
            'excerpt' => get_the_excerpt($post),
        ];
    }

    /** Converte a query principal do WordPress em dados simples. */
    public static function fromMainQuery(): array
    {
        global $wp_query;
        return array_map([self::class, 'map'], $wp_query->posts ?? []);
    }

    public static function latest(int $limit = 3): array
    {
        return array_map([self::class, 'map'], get_posts(['posts_per_page' => $limit, 'no_found_rows' => true]));
    }
}
