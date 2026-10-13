<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;

/** Texto individual do blog (single.php) e de vídeos/sons (single-video.php, single-som.php). */
final class ArticleController extends Controller
{
    public function show(): void
    {
        the_post();
        $isProduct = is_singular('product');
        $product = $isProduct && function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : false;
        $productPrice = '';
        $productShortDescription = '';
        $productSku = '';
        $productCategories = [];
        $productTags = [];
        $productPurchaseForm = '';
        $affiliateUrl = '';
        $affiliateButtonText = '';
        $physicalEditionUrl = '';
        $ebookEditionUrl = '';
        $affiliateLinks = [];

        if ($product instanceof \WC_Product) {
            $GLOBALS['product'] = $product;
            $productPrice = $product->get_price_html();
            $productShortDescription = apply_filters('woocommerce_short_description', $product->get_short_description());
            $productSku = (string) $product->get_sku();
            $productCategories = self::productTerms($product->get_id(), 'product_cat');
            $productTags = self::productTerms($product->get_id(), 'product_tag');
            $physicalEditionUrl = (string) get_post_meta($product->get_id(), '_clo_physical_edition_url', true);
            $ebookEditionUrl = (string) get_post_meta($product->get_id(), '_clo_ebook_affiliate_url', true);

            if ($product->is_type('external')) {
                $affiliateUrl = (string) $product->get_product_url();
                $affiliateButtonText = (string) $product->get_button_text();
            } elseif (function_exists('woocommerce_template_single_add_to_cart')) {
                ob_start();
                woocommerce_template_single_add_to_cart();
                $productPurchaseForm = (string) ob_get_clean();
            }
        }

        $affiliateCandidates = [];
        if ($affiliateUrl !== '') {
            $affiliateCandidates[] = [
                'url' => $affiliateUrl,
                'label' => $affiliateButtonText ?: 'Comprar',
            ];
        }
        if ($physicalEditionUrl !== '') {
            $affiliateCandidates[] = ['url' => $physicalEditionUrl, 'label' => 'Comprar edição física'];
        }
        if ($ebookEditionUrl !== '') {
            $affiliateCandidates[] = ['url' => $ebookEditionUrl, 'label' => 'Comprar e-book'];
        }
        $affiliateLinks = self::uniqueAffiliateLinks($affiliateCandidates);

        $this->render('pages/article', [
            'title'     => get_the_title(),
            'date'      => $isProduct ? '' : get_the_date(),
            'dateIso'   => $isProduct ? '' : get_the_date('c'),
            'thumb'     => get_the_post_thumbnail_url(null, 'full') ?: '',
            'content'   => apply_filters('the_content', get_the_content()),
            'isProduct' => $isProduct,
            'productPrice' => $productPrice,
            'productShortDescription' => $productShortDescription,
            'productSku' => $productSku,
            'productCategories' => $productCategories,
            'productTags' => $productTags,
            'productPurchaseForm' => $productPurchaseForm,
            'affiliateLinks' => $affiliateLinks,
            'bodyClass' => $isProduct ? 'pg-produto' . ($affiliateLinks ? ' pg-produto--afiliado' : '') : 'pg-texto',
        ]);
    }

    private static function uniqueAffiliateLinks(array $links): array
    {
        $unique = [];
        $seen = [];
        foreach ($links as $link) {
            $url = isset($link['url']) ? esc_url_raw((string) $link['url']) : '';
            if (!preg_match('~^https?://~i', $url) || isset($seen[$url])) {
                continue;
            }
            $seen[$url] = true;
            $unique[] = ['url' => $url, 'label' => (string) ($link['label'] ?? 'Comprar')];
        }
        return $unique;
    }

    private static function productTerms(int $productId, string $taxonomy): array
    {
        $terms = get_the_terms($productId, $taxonomy);
        if (!$terms || is_wp_error($terms)) {
            return [];
        }

        $links = [];
        foreach ($terms as $term) {
            $url = get_term_link($term);
            if (!is_wp_error($url)) {
                $links[] = ['name' => $term->name, 'url' => $url];
            }
        }
        return $links;
    }
}
