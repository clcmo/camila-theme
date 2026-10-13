<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Models\Book;

final class WooCommerceController
{
    private const PRODUCT_META = '_clo_woocommerce_product_id';
    private const PHYSICAL_EDITION_META = '_clo_physical_edition_url';
    private const EBOOK_EDITION_META = '_clo_ebook_affiliate_url';

    public static function init(): void
    {
        add_action('save_post_' . Book::TYPE, [self::class, 'syncBookProduct'], 20, 3);
        add_action('add_meta_boxes_' . Book::TYPE, [self::class, 'addProductBox']);
        add_action('woocommerce_product_options_general_product_data', [self::class, 'renderEditionFields']);
        add_action('woocommerce_admin_process_product_object', [self::class, 'saveEditionFields']);
        add_action('wp', [self::class, 'setupCatalogOrdering'], 99);
        add_filter('woocommerce_default_catalog_orderby', [self::class, 'defaultCatalogOrderby']);
    }

    public static function setupCatalogOrdering(): void
    {
        if (!function_exists('is_shop') || !function_exists('is_product_taxonomy')) {
            return;
        }
        if (!is_shop() && !is_product_taxonomy()) {
            return;
        }

        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        add_action('woocommerce_before_shop_loop', [self::class, 'renderCatalogOrderingButtons'], 30);
    }

    public static function defaultCatalogOrderby(string $default): string
    {
        return 'date';
    }

    public static function renderCatalogOrderingButtons(): void
    {
        $filters = [
            'date'       => 'Mais recentes',
            'popularity' => 'Mais vendidas',
            'rating'     => 'Mais avaliadas',
        ];
        $current = isset($_GET['orderby']) && is_string($_GET['orderby'])
            ? sanitize_key(wp_unslash($_GET['orderby']))
            : 'date';
        $baseUrl = remove_query_arg(['paged', 'product-page']);

        echo '<nav class="loja-filtros" aria-label="Ordenar produtos">';
        echo '<span class="loja-filtros__rotulo">Ordenar por</span>';
        foreach ($filters as $orderby => $label) {
            $active = $current === $orderby;
            $url = add_query_arg('orderby', $orderby, $baseUrl);
            echo '<a class="loja-filtro' . ($active ? ' is-ativo' : '') . '" href="' . esc_url($url) . '"' . ($active ? ' aria-current="page"' : '') . '>' . esc_html($label) . '</a>';
        }
        echo '</nav>';
    }

    public static function syncBookProduct(int $postId, \WP_Post $post, bool $update): void
    {
        if (!function_exists('wc_get_product') || !class_exists('WC_Product_Simple')) {
            return;
        }
        if (wp_is_post_revision($postId) || wp_is_post_autosave($postId) || $post->post_status === 'auto-draft') {
            return;
        }
        if (!current_user_can('edit_post', $postId) || trim($post->post_title) === '') {
            return;
        }

        $productId = (int) get_post_meta($postId, self::PRODUCT_META, true);
        $product = $productId ? wc_get_product($productId) : false;
        if (!($product instanceof \WC_Product)) {
            $product = new \WC_Product_Simple();
        }

        if (!$product->get_id()) {
            $product->set_status('draft');
            $product->set_catalog_visibility('visible');
        }
        $product->set_name($post->post_title);
        $product->set_description($post->post_content);
        $product->set_short_description($post->post_excerpt);
        $product->set_image_id((int) get_post_thumbnail_id($postId));

        $productId = $product->save();
        if ($productId) {
            update_post_meta($postId, self::PRODUCT_META, $productId);
        }
    }

    public static function addProductBox(): void
    {
        add_meta_box(
            'clo_woocommerce_product',
            'Produto WooCommerce',
            [self::class, 'renderProductBox'],
            Book::TYPE,
            'side',
            'high'
        );
    }

    public static function renderProductBox(\WP_Post $post): void
    {
        if (!function_exists('wc_get_product')) {
            echo '<p>Ative o WooCommerce para criar o produto automaticamente.</p>';
            return;
        }

        $productId = (int) get_post_meta($post->ID, self::PRODUCT_META, true);
        $product = $productId ? wc_get_product($productId) : false;
        if ($product instanceof \WC_Product) {
            $editLink = get_edit_post_link($product->get_id());
            $status = get_post_status($product->get_id());
            $statusLabel = $status === 'publish' ? 'Publicado' : 'Rascunho';
            echo '<p>Produto: ' . esc_html($statusLabel) . '</p>';
            if ($editLink) {
                echo '<p><a href="' . esc_url($editLink) . '">Editar produto</a></p>';
            }
            return;
        }

        echo '<p>Ao salvar este livro, será criado um produto como rascunho.</p>';
    }

    public static function renderEditionFields(): void
    {
        woocommerce_wp_text_input([
            'id'          => self::PHYSICAL_EDITION_META,
            'label'       => 'Link da edição física',
            'type'        => 'url',
            'desc_tip'    => true,
            'description' => 'Link afiliado da edição impressa, exibido na página deste produto.',
        ]);

        woocommerce_wp_text_input([
            'id'          => self::EBOOK_EDITION_META,
            'label'       => 'Link afiliado do e-book',
            'type'        => 'url',
            'desc_tip'    => true,
            'description' => 'No produto físico, este link exibe uma opção para comprar o e-book.',
        ]);
    }

    public static function saveEditionFields(\WC_Product $product): void
    {
        foreach ([self::PHYSICAL_EDITION_META, self::EBOOK_EDITION_META] as $metaKey) {
            if (!isset($_POST[$metaKey]) || !is_string($_POST[$metaKey])) {
                continue;
            }

            $url = esc_url_raw(wp_unslash($_POST[$metaKey]));
            if ($url !== '') {
                $product->update_meta_data($metaKey, $url);
            } else {
                $product->delete_meta_data($metaKey);
            }
        }
    }
}