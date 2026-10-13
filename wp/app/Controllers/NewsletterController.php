<?php
namespace CamilaOliveira\Controllers;

/** Inscrição na newsletter. Guarda e-mails em uma opção e avisa a autora; pode ser trocada por shortcode (Personalizar). */
final class NewsletterController
{
    public static function init(): void
    {
        add_action('admin_post_nopriv_clo_newsletter', [self::class, 'handle']);
        add_action('admin_post_clo_newsletter', [self::class, 'handle']);
    }

    public static function handle(): void
    {
        $back = wp_get_referer() ?: home_url('/');
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'clo_newsletter')) {
            wp_safe_redirect(add_query_arg('inscricao', 'erro', $back) . '#newsletter');
            exit;
        }
        // campo-armadilha contra robôs
        if (!empty($_POST['site'])) {
            wp_safe_redirect($back);
            exit;
        }
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        if (!is_email($email)) {
            wp_safe_redirect(add_query_arg('inscricao', 'invalido', $back) . '#newsletter');
            exit;
        }
        $list = (array) get_option('clo_newsletter_list', []);
        if (!in_array($email, $list, true)) {
            $list[] = $email;
            update_option('clo_newsletter_list', $list, false);
            wp_mail(get_option('admin_email'), 'Nova inscrição na newsletter', "Novo e-mail inscrito: {$email}");
        }
        wp_safe_redirect(add_query_arg('inscricao', 'ok', $back) . '#newsletter');
        exit;
    }

    public static function status(): string
    {
        $s = isset($_GET['inscricao']) ? sanitize_key(wp_unslash($_GET['inscricao'])) : '';
        switch ($s) {
            case 'ok':
                return 'Inscrição feita. Obrigada por acompanhar!';
            case 'invalido':
                return 'Esse e-mail não parece válido. Confira e tente de novo.';
            case 'erro':
                return 'Não foi possível enviar. Recarregue a página e tente de novo.';
            default:
                return '';
        }
    }
}
