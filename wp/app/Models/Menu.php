<?php
namespace CamilaOliveira\Models;

/** Menu principal: usa o menu do painel (local "principal") ou, se vazio, Início/Blog/Sobre/Livros/Contato. */
final class Menu
{
    /** @return array<int,array{label:string,url:string,current:bool}> */
    public static function primary(): array
    {
        $locations = get_nav_menu_locations();
        if (!empty($locations['principal'])) {
            $items = wp_get_nav_menu_items($locations['principal']) ?: [];
            return array_map(static fn($i) => [
                'label' => $i->title, 'url' => $i->url,
                'current' => !empty($i->current) || !empty($i->current_item_ancestor),
            ], array_filter($items, static fn($i) => (int) $i->menu_item_parent === 0));
        }

        $blogId = (int) get_option('page_for_posts');
        $defaults = [
            'Início'  => home_url('/'),
            'Blog'    => $blogId ? get_permalink($blogId) : home_url('/blog/'),
            'Sobre'   => home_url('/sobre/'),
            'Livros'  => home_url('/livros/'),
            'Contato' => home_url('/contato/'),
        ];
        $here = trailingslashit(home_url(add_query_arg([])));
        $out = [];
        foreach ($defaults as $label => $url) {
            $out[] = ['label' => $label, 'url' => $url, 'current' => trailingslashit($url) === $here];
        }
        return $out;
    }
}
