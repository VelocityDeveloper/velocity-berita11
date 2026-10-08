<?php

/**
 * Pengaturan Customizer bawaan WordPress (pengganti Kirki).
 *
 * Nama setting sama dengan versi Kirki (theme_mod) sehingga isian lama
 * tetap terbaca setelah pembaruan.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('velocity_berita11_default_color')) {
    function velocity_berita11_default_color()
    {
        return '#e3093d';
    }
}

/**
 * Warna tema yang tampil: color_theme, lalu Primary Color induk bila sudah
 * diubah dari bawaannya, lalu warna bawaan desain Berita 11.
 */
if (!function_exists('velocity_berita11_warna')) {
    function velocity_berita11_warna()
    {
        $color = sanitize_hex_color((string) get_theme_mod('color_theme', ''));
        if ($color) {
            return $color;
        }

        $primary = sanitize_hex_color((string) get_theme_mod('primary_color', ''));
        if ($primary && '#1e73be' !== strtolower($primary)) {
            return $primary;
        }

        return velocity_berita11_default_color();
    }
}

if (!function_exists('velocity_berita11_banner_slots')) {
    /**
     * Slot banner: id => [label, keterangan].
     */
    function velocity_berita11_banner_slots()
    {
        return array(
            'banner_header1' => array(__('Banner Header', 'justg'), __('Sebelah logo, 728x90.', 'justg')),
            'banner_single1' => array(__('Banner Single Atas', 'justg'), __('Tampil di atas gambar artikel, 468x60.', 'justg')),
            'banner_single2' => array(__('Banner Single Bawah', 'justg'), __('Tampil di bawah isi artikel, 468x60.', 'justg')),
            'banner_footer'  => array(__('Banner Footer', 'justg'), __('Tampil di atas footer, 728x90.', 'justg')),
        );
    }
}

if (!function_exists('velocity_berita11_sosmed_list')) {
    /**
     * Sosial media: platform => label.
     */
    function velocity_berita11_sosmed_list()
    {
        return array(
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'youtube'   => 'Youtube',
            'twitter'   => 'X (Twitter)',
            'tiktok'    => 'TikTok',
        );
    }
}

add_action('customize_register', 'velocity_berita11_customize_register', 20);
function velocity_berita11_customize_register(WP_Customize_Manager $wp_customize)
{
    $wp_customize->add_panel('panel_berita', array(
        'priority' => 10,
        'title'    => __('Berita', 'justg'),
    ));

    // Warna.
    $wp_customize->add_section('section_colorberita', array(
        'panel'    => 'panel_berita',
        'title'    => __('Warna', 'justg'),
        'priority' => 10,
    ));
    $wp_customize->add_setting('color_theme', array(
        'default'           => velocity_berita11_default_color(),
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_theme', array(
        'label'       => __('Warna Tema', 'justg'),
        'description' => __('Garis artikel, tombol, label tag, dan penanda breadcrumb.', 'justg'),
        'section'     => 'section_colorberita',
    )));

    // Banner.
    $wp_customize->add_section('setting_banner', array(
        'panel'    => 'panel_berita',
        'title'    => __('Banner', 'justg'),
        'priority' => 20,
    ));
    foreach (velocity_berita11_banner_slots() as $id => $slot) {
        $wp_customize->add_setting($id, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, array(
            'label'       => $slot[0],
            'description' => $slot[1],
            'section'     => 'setting_banner',
        )));
        $wp_customize->add_setting($id . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control($id . '_link', array(
            'type'        => 'url',
            /* translators: %s: nama banner */
            'label'       => sprintf(__('Link %s', 'justg'), $slot[0]),
            'description' => __('Kosongkan bila banner tidak perlu ditautkan.', 'justg'),
            'section'     => 'setting_banner',
        ));
    }

    // Sosial media.
    $wp_customize->add_section('section_sosmed', array(
        'panel'    => 'panel_berita',
        'title'    => __('Sosial Media', 'justg'),
        'priority' => 30,
    ));
    foreach (velocity_berita11_sosmed_list() as $platform => $label) {
        $wp_customize->add_setting('sosmed_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('sosmed_' . $platform, array(
            'type'        => 'url',
            'label'       => $label,
            /* translators: %s: contoh alamat */
            'description' => sprintf(__('Contoh: https://www.%s.com/namaakun. Kosongkan untuk menyembunyikan ikon.', 'justg'), $platform),
            'section'     => 'section_sosmed',
        ));
    }
}

add_action('customize_preview_init', 'velocity_berita11_customize_preview');
function velocity_berita11_customize_preview()
{
    wp_add_inline_script(
        'customize-preview',
        "wp.customize('color_theme',function(v){v.bind(function(c){document.documentElement.style.setProperty('--color-theme',c);});});"
    );
}

/**
 * Migrasi sekali dari versi Kirki: TikTok dulu tersimpan di `sosmedtiktok`
 * (salah ketik), sedangkan ikon membaca `sosmed_tiktok`.
 */
add_action('after_setup_theme', 'velocity_berita11_migrasi_kirki', 5);
function velocity_berita11_migrasi_kirki()
{
    if (get_theme_mod('velocity_berita11_migrasi', 0) >= 1) {
        return;
    }

    $tiktok = get_theme_mod('sosmedtiktok', '');
    if ($tiktok && !get_theme_mod('sosmed_tiktok', '')) {
        set_theme_mod('sosmed_tiktok', esc_url_raw($tiktok));
    }
    remove_theme_mod('sosmedtiktok');

    set_theme_mod('velocity_berita11_migrasi', 1);
}

add_action('wp_head', 'velocity_berita11_inline_css', 30);
function velocity_berita11_inline_css()
{
    echo '<style id="velocity-berita11-css">:root{--color-theme:' . velocity_berita11_warna() . ';}</style>';
}
