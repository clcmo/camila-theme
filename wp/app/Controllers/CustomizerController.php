<?php
namespace CamilaOliveira\Controllers;

/** Opções editáveis em Aparência → Personalizar → "Camila L. Oliveira". */
final class CustomizerController
{
    public static function init(): void
    {
        add_action('customize_register', [self::class, 'register']);
    }

    /** Valores padrão, usados também pelos controllers. */
    public static function defaults(): array
    {
        return [
            'clo_hero_image'       => '',
            'clo_hero_alt'         => 'Retrato de Camila L. Oliveira',
            'clo_newsletter_title' => 'Receba em seu e-mail gratuitamente as novidades',
            'clo_newsletter_code'  => '',
            'clo_youtube_channel'  => '',
            'clo_books_intro'      => 'É na escrita que Camila apresenta ensaios sobre o cotidiano e a sociedade, e dela surgem obras envolventes aos amantes da literatura em geral.',
        ];
    }

    public static function get(string $key): string
    {
        return (string) get_theme_mod($key, self::defaults()[$key] ?? '');
    }

    public static function register(\WP_Customize_Manager $wp): void
    {
        $wp->add_section('clo_site', ['title' => 'Camila L. Oliveira', 'priority' => 30]);

        $wp->add_setting('clo_hero_image', ['sanitize_callback' => 'absint']);
        $wp->add_control(new \WP_Customize_Media_Control($wp, 'clo_hero_image', [
            'label' => 'Foto da página inicial', 'section' => 'clo_site', 'mime_type' => 'image',
        ]));

        $fields = [
            'clo_hero_alt'         => ['Texto alternativo da foto', 'text', 'sanitize_text_field'],
            'clo_newsletter_title' => ['Chamada da newsletter', 'text', 'sanitize_text_field'],
            'clo_newsletter_code'  => ['Shortcode de newsletter (opcional)', 'text', 'sanitize_text_field'],
            'clo_youtube_channel'  => ['Endereço do canal no YouTube', 'url', 'esc_url_raw'],
            'clo_books_intro'      => ['Texto de abertura da página Livros', 'textarea', 'sanitize_textarea_field'],
        ];
        foreach ($fields as $id => [$label, $type, $sanitize]) {
            $wp->add_setting($id, ['default' => self::defaults()[$id], 'sanitize_callback' => $sanitize]);
            $wp->add_control($id, ['label' => $label, 'section' => 'clo_site', 'type' => $type]);
        }
    }
}
