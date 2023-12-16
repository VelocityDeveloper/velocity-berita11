<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

    if (class_exists('Kirki')) :

        Kirki::add_panel('panel_berita', [
            'priority'    => 10,
            'title'       => esc_html__('Berita', 'justg'),
            'description' => esc_html__('', 'justg'),
        ]);

        ///Section Color
        Kirki::add_section('section_colorberita', [
            'panel'    => 'panel_berita',
            'title'    => __('Warna', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme',
            'label'       => __('Color Theme', 'justg'),
            'description' => esc_html__('', 'justg'),
            'section'     => 'section_colorberita',
            'default'     => 'green',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme',
                ],
                [
                    'element'   => '.border-color-theme',
                    'property'  => '--bs-border-color',
                ]
            ],
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'color',
            'settings'    => 'color_theme_second',
            'label'       => __('Color Theme Secondary', 'justg'),
            'description' => esc_html__('', 'justg'),
            'section'     => 'section_colorberita',
            'default'     => 'green',
            'transport'   => 'auto',
            'output'      => [
                [
                    'element'   => ':root',
                    'property'  => '--color-theme-second',
                ]
            ],
        ]);

        // Section Iklan
        Kirki::add_section('setting_banner', [
            'panel'    => 'panel_berita',
            'title'    => __('Banner Setting', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'banner_header1',
            'label'       => esc_html__('Banner Header1', 'justg'),
            'description' => esc_html__('', 'justg'),
            'section'     => 'setting_banner',
            'default'     => '',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'banner_single1',
            'label'       => esc_html__('Banner Single', 'justg'),
            'description' => esc_html__('Tampil di atas feature image.', 'justg'),
            'section'     => 'setting_banner',
            'default'     => '',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'banner_single2',
            'label'       => esc_html__('Banner Single', 'justg'),
            'description' => esc_html__('Tampil di bawah konten.', 'justg'),
            'section'     => 'setting_banner',
            'default'     => '',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'image',
            'settings'    => 'banner_footer',
            'label'       => esc_html__('Banner Footer', 'justg'),
            'description' => esc_html__('Tampil di footer.', 'justg'),
            'section'     => 'setting_banner',
            'default'     => '',
        ]);

        ///Section Sosmed
        Kirki::add_section('section_sosmed', [
            'panel'    => 'panel_berita',
            'title'    => __('Social Media', 'justg'),
            'priority' => 10,
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'sosmed_facebook',
            'label'       => esc_html__('Facebook', 'justg'),
            'description' => esc_html__('ex. https://www.facebook.com/', 'justg'),
            'section'     => 'section_sosmed',
            'default'     => 'https://www.facebook.com/',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'sosmed_instagram',
            'label'       => esc_html__('Instagram', 'justg'),
            'description' => esc_html__('ex. https://www.instagram.com/', 'justg'),
            'section'     => 'section_sosmed',
            'default'     => 'https://www.instagram.com/',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'sosmed_twitter',
            'label'       => esc_html__('Twitter', 'justg'),
            'description' => esc_html__('ex. https://www.twitter.com/', 'justg'),
            'section'     => 'section_sosmed',
            'default'     => 'https://www.twitter.com/',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'sosmed_youtube',
            'label'       => esc_html__('Youtube', 'justg'),
            'description' => esc_html__('ex. https://www.youtube.com/', 'justg'),
            'section'     => 'section_sosmed',
            'default'     => 'https://www.youtube.com/',
        ]);
        Kirki::add_field('justg_config', [
            'type'        => 'text',
            'settings'    => 'sosmedtiktok',
            'label'       => esc_html__('Tiktok', 'justg'),
            'description' => esc_html__('ex. https://www.tiktok.com/', 'justg'),
            'section'     => 'section_sosmed',
            'default'     => 'https://www.tiktok.com/',
        ]);

    endif;

    register_nav_menus(
        array(
            'secondary' => __('Secondary Menu', 'justg'),
        )
    );

    //remove action from Parent Theme
    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');
}

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header id="wrapper-header">';
        echo '<div id="wrapper-navbar" class="wrapper-fluid wrapper-navbar position-relative" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</div>';
        echo '</header>';
    }
}

///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
    require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
    echo '<div class="px-2">';
    echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 p-0 container">';
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
    echo '</div>';
    echo '</div>';
}

// banner func
function vdbanner($sett, $class)
{
    $img = velocitytheme_option($sett);
    if ($img) :
        $banner = '<div class="' . $class . '"><img src="' . $img . '" /></div>';
    endif;
    return $banner;
}
