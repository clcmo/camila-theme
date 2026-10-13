<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;

final class ShopController extends Controller
{
    public function index(): void
    {
        global $wp_query;

        $products = [];
        while (have_posts()) {
            the_post();
            $product = wc_get_product(get_the_ID());
            if (!$product instanceof \WC_Product) {
                continue;
            }

            $productId = $product->get_id();
            $isExternal = $product->is_type('external');
            $imageId = (int) $product->get_image_id();
            $products[] = [
                'title' => $product->get_name(),
                'url' => get_permalink($productId),
                'image' => $imageId ? (string) wp_get_attachment_image_url($imageId, 'woocommerce_thumbnail') : '',
                'price' => $product->get_price_html(),
                'purchaseUrl' => $isExternal ? $product->get_product_url() : get_permalink($productId),
                'purchaseLabel' => $isExternal ? ($product->get_button_text() ?: 'Comprar') : 'Ver produto',
                'isExternal' => $isExternal,
            ];
        }
        wp_reset_postdata();

        $currentPage = max(1, (int) get_query_var('paged'));
        $totalPages = max(1, (int) $wp_query->max_num_pages);
        $pagination = paginate_links([
            'total' => $totalPages,
            'current' => $currentPage,
            'type' => 'list',
        ]) ?: '';
        $title = function_exists('is_product_taxonomy') && is_product_taxonomy()
            ? single_term_title('', false)
            : 'Loja';

        $this->render('pages/shop', [
            'title' => $title ?: 'Loja',
            'products' => $products,
            'foundProducts' => (int) $wp_query->found_posts,
            'pagination' => $pagination,
            'bodyClass' => 'pg-loja',
        ]);
    }
}