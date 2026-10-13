<?php
namespace CamilaOliveira\Controllers;

use CamilaOliveira\Core\Controller;

/** Página Contato: exibe o formulário e trata o envio. */
final class ContactController extends Controller
{
    public static function init(): void
    {
        add_action('admin_post_nopriv_clo_contact', [self::class, 'handle']);
        add_action('admin_post_clo_contact', [self::class, 'handle']);
    }

    public function index(): void
    {
        $status = isset($_GET['contato']) ? sanitize_key(wp_unslash($_GET['contato'])) : '';
        $messages = [
            'ok'   => 'Mensagem enviada. Respondo assim que possível.',
            'erro' => 'Preencha nome, e-mail e mensagem para enviar.',
        ];
        $this->render('pages/contact', [
            'title'   => get_the_title(),
            'intro'   => apply_filters('the_content', get_post_field('post_content', get_queried_object_id())),
            'message' => $messages[$status] ?? '',
            'ok'      => $status === 'ok',
            'bodyClass' => 'pg-contato',
        ]);
    }

    public static function handle(): void
    {
        $back = wp_get_referer() ?: home_url('/contato/');
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'clo_contact') || !empty($_POST['site'])) {
            wp_safe_redirect(add_query_arg('contato', 'erro', $back));
            exit;
        }
        $name  = sanitize_text_field(wp_unslash($_POST['nome'] ?? ''));
        $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
        $text  = sanitize_textarea_field(wp_unslash($_POST['mensagem'] ?? ''));
        if ($name === '' || !is_email($email) || $text === '') {
            wp_safe_redirect(add_query_arg('contato', 'erro', $back));
            exit;
        }
        wp_mail(
            get_option('admin_email'),
            "Contato pelo site: {$name}",
            $text . "\n\n— {$name} <{$email}>",
            ["Reply-To: {$name} <{$email}>"]
        );
        wp_safe_redirect(add_query_arg('contato', 'ok', $back));
        exit;
    }
}
