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
        if ($primary && !in_array(strtolower($primary), array('#1e73be', '#1c4e88'), true)) {
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

if (!function_exists('velocity_berita11_warna_desain')) {
    /**
     * Warna teks & link desain Berita 11. Versi Kirki menampilkan warna bawaan
     * CSS induk karena induk tidak mencetak warna Customizer saat Kirki aktif.
     */
    function velocity_berita11_warna_desain()
    {
        return array(
            'body_text_color'   => '#212529',
            'heading_color'     => '#212529',
            'link_color'        => '#1c4e88',
            'link_hover_color'  => '#163e6d',
            'link_active_color' => '#1c4e88',
            'primary_color'     => '#1c4e88',
        );
    }
}

// Bawaan warna induk untuk instalasi baru.
add_filter('justg_theme_default_settings', 'velocity_berita11_default_settings');
function velocity_berita11_default_settings($defaults)
{
    return array_merge($defaults, velocity_berita11_warna_desain());
}

/**
 * Migrasi sekali dari versi Kirki: TikTok dulu tersimpan di `sosmedtiktok`
 * (salah ketik), sedangkan ikon membaca `sosmed_tiktok`.
 */
add_action('after_setup_theme', 'velocity_berita11_migrasi_kirki', 5);
function velocity_berita11_migrasi_kirki()
{
    $versi = (int) get_theme_mod('velocity_berita11_migrasi', 0);
    if ($versi >= 2) {
        return;
    }

    // Warna induk yang masih bawaan (belum pernah diubah) diganti warna yang
    // dulu tampil, agar tampilan sama seperti versi Kirki.
    $bawaan_induk = array(
        'body_text_color'   => '#333333',
        'heading_color'     => '#121212',
        'link_color'        => '#002b5b',
        'link_hover_color'  => '#333333',
        'link_active_color' => '#333333',
        'primary_color'     => '#1e73be',
    );
    foreach (velocity_berita11_warna_desain() as $mod => $warna) {
        $simpan = get_theme_mod($mod, null);
        if (null === $simpan || strtolower((string) $simpan) === $bawaan_induk[$mod]) {
            set_theme_mod($mod, $warna);
        }
    }

    if ($versi >= 1) {
        set_theme_mod('velocity_berita11_migrasi', 2);
        return;
    }

    $tiktok = get_theme_mod('sosmedtiktok', '');
    if ($tiktok && !get_theme_mod('sosmed_tiktok', '')) {
        set_theme_mod('sosmed_tiktok', esc_url_raw($tiktok));
    }
    remove_theme_mod('sosmedtiktok');

    set_theme_mod('velocity_berita11_migrasi', 2);
}

add_action('wp_head', 'velocity_berita11_inline_css', 30);
function velocity_berita11_inline_css()
{
    echo '<style id="velocity-berita11-css">:root{--color-theme:' . velocity_berita11_warna() . ';}</style>';
}
