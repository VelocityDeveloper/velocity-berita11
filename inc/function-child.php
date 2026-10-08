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

    register_nav_menus(
        array(
            'secondary' => __('Secondary Menu', 'justg'),
        )
    );

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
function vdbanner($sett, $class, $loading = 'lazy')
{
    $img = velocitytheme_option($sett);
    if (!$img) {
        return '';
    }

    $html = '<img src="' . esc_url($img) . '" alt="' . esc_attr__('Banner', 'justg') . '" class="img-fluid" loading="' . esc_attr($loading) . '" decoding="async">';
    $link = velocitytheme_option($sett . '_link');
    if ($link) {
        $html = '<a href="' . esc_url($link) . '" target="_blank" rel="noopener sponsored">' . $html . '</a>';
    }

    return '<div class="vd-banner ' . esc_attr($class) . '">' . $html . '</div>';
}

/**
 * Gambar unggulan artikel memakai srcset WordPress; artikel tanpa gambar
 * mendapat gambar pengganti agar susunan kartu tidak berantakan.
 */
function velocity_berita11_thumbnail($size = 'medium', $attr = array())
{
    $attr = wp_parse_args($attr, array(
        'class'    => 'ratio-thumbnail-image',
        'alt'      => the_title_attribute(array('echo' => false)),
        'loading'  => 'lazy',
        'decoding' => 'async',
    ));

    if (has_post_thumbnail()) {
        return get_the_post_thumbnail(null, $size, $attr);
    }

    return '<img src="' . esc_url(get_stylesheet_directory_uri() . '/img/no-image.svg') . '" class="' . esc_attr($attr['class']) . ' no-image" alt="" width="300" height="200" loading="lazy">';
}

// Tombol bagikan (justg_share pindah dari induk ke Velocity Addons 2.x).
function velocity_berita11_share()
{
    if (function_exists('justg_share')) {
        echo justg_share();
        return;
    }

    $url   = rawurlencode(get_permalink());
    $title = rawurlencode(html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'));
    $links = array(
        'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
        'X'        => 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url,
        'WhatsApp' => 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url,
        'Telegram' => 'https://t.me/share/url?url=' . $url . '&text=' . $title,
    );

    echo '<div class="d-flex align-items-center flex-wrap gap-1"><small class="me-1 text-muted">' . esc_html__('Bagikan:', 'justg') . '</small>';
    foreach ($links as $label => $href) {
        echo '<a class="btn btn-sm btn-light border" href="' . esc_url($href) . '" target="_blank" rel="noopener nofollow">' . esc_html($label) . '</a>';
    }
    echo '</div>';
}

/**
 * Breadcrumb: halaman arsip memakai judul arsip (breadcrumb induk di arsip
 * kategori mengambil kategori artikel pertama, bukan kategori yang dibuka).
 */
function velocity_berita11_breadcrumb()
{
    if (!is_archive() && !is_search()) {
        echo justg_breadcrumb();
        return;
    }

    // Markup & pemisah sama dengan breadcrumb induk.
    $separator = '<span class="separator"> ' . esc_html(velocitytheme_option('text_breadcrumb_separator', '/')) . ' </span>';
    $title     = is_search() ? sprintf(__('Pencarian: %s', 'justg'), get_search_query()) : wp_strip_all_tags(get_the_archive_title());
    $link      = is_search() ? get_search_link() : (is_category() || is_tag() || is_tax() ? get_term_link(get_queried_object()) : '');

    echo '<div class="justg-breadcrumbs"><div class="breadcrumbs pb-2"><div class="breadcrumbs-inner">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'justg') . '</a>' . $separator;
    if ($link && !is_wp_error($link)) {
        echo '<a href="' . esc_url($link) . '">' . esc_html($title) . '</a>';
    } else {
        echo '<span>' . esc_html($title) . '</span>';
    }
    echo '</div></div></div>';
}

// Judul arsip tanpa awalan "Kategori:" / "Category:".
add_filter('get_the_archive_title_prefix', '__return_empty_string');
