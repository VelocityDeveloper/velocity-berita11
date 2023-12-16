<?php

/**
 * Kumpulan shortcode yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
//[resize-thumbnail width="300" height="150" linked="true" class="w-100"]
add_shortcode('resize-thumbnail', 'resize_thumbnail');
function resize_thumbnail($atts)
{
    ob_start();
    global $post;
    $atribut = shortcode_atts(array(
        'output'    => 'image', /// image or url
        'width'        => '300', ///width image
        'height'    => '150', ///height image
        'crop'      => 'false',
        'upscale'       => 'true',
        'linked'       => 'true', ///return link to post	
        'class'       => 'w-100', ///return class name to img	
        'attachment'     => 'true'
    ), $atts);

    $output            = $atribut['output'];
    $attach         = $atribut['attachment'];
    $width          = $atribut['width'];
    $height         = $atribut['height'];
    $crop           = $atribut['crop'];
    $upscale        = $atribut['upscale'];
    $linked            = $atribut['linked'];
    $class            = $atribut['class'] ? 'class="' . $atribut['class'] . '"' : '';
    $urlimg            = get_the_post_thumbnail_url($post->ID, 'full');

    if (empty($urlimg) && $attach == 'true') {
        $attachments = get_posts(array(
            'post_type'         => 'attachment',
            'posts_per_page'     => 1,
            'post_parent'         => $post->ID,
            'orderby'          => 'date',
            'order'            => 'DESC',
        ));
        if ($attachments) {
            $urlimg = wp_get_attachment_url($attachments[0]->ID, 'full');
        }
    }

    if ($urlimg) :
        $urlresize      = aq_resize($urlimg, $width, $height, $crop, true, $upscale);
        if ($output == 'image') :
            if ($linked == 'true') :
                echo '<a href="' . get_the_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
            endif;
            echo '<img src="' . $urlresize . '" width="' . $width . '" height="' . $height . '" loading="lazy" ' . $class . '>';
            if ($linked == 'true') :
                echo '</a>';
            endif;
        else :
            echo $urlresize;
        endif;

    else :
        if ($linked == 'true') :
            echo '<a href="' . get_the_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
        endif;
        echo '<svg style="background-color: #ececec;width: 100%;height: auto;" width="' . $width . '" height="' . $height . '"></svg>';
        if ($linked == 'true') :
            echo '</a>';
        endif;
    endif;

    return ob_get_clean();
}

//[excerpt count="150"]
add_shortcode('excerpt', 'vd_getexcerpt');
function vd_getexcerpt($atts)
{
    ob_start();
    global $post;
    $atribut = shortcode_atts(array(
        'count'    => '150', /// count character
    ), $atts);

    $count        = $atribut['count'];
    $excerpt    = get_the_content();
    $excerpt     = strip_tags($excerpt);
    $excerpt     = substr($excerpt, 0, $count);
    $excerpt     = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt     = '' . $excerpt . '...';

    echo $excerpt;

    return ob_get_clean();
}

// [vd-breadcrumbs]
add_shortcode('vd-breadcrumbs', 'vd_breadcrumbs');
function vd_breadcrumbs()
{
    ob_start();
    echo justg_breadcrumb();
    return ob_get_clean();
}

//[ratio-thumbnail size="medium" ratio="16:9"]
add_shortcode('ratio-thumbnail', 'ratio_thumbnail');
function ratio_thumbnail($atts)
{
    ob_start();
    global $post;

    $atribut = shortcode_atts(array(
        'size'  => 'medium', // thumbnail, medium, large, full
        'ratio' => '16:9', // 16:9, 8:5, 4:3, 3:2, 1:1
        'class' => '',
    ), $atts);

    $size       = $atribut['size'];
    $class      = $atribut['class'];
    $ratio      = $atribut['ratio'];
    $ratio      = $ratio ? str_replace(":", "-", $ratio) : '';
    $urlimg     = get_the_post_thumbnail_url($post->ID, $size);

    echo '<div class="ratio-thumbnail">';
    echo '<a class="ratio-thumbnail-link" href="' . get_the_permalink($post->ID) . '" title="' . get_the_title($post->ID) . '">';
    echo '<div class="' . $class . ' ratio-thumbnail-box ratio-thumbnail-' . $ratio . '" style="background-image: url(' . $urlimg . ');">';
    echo '<img src="' . $urlimg . '" loading="lazy" class="ratio-thumbnail-image"/>';
    echo '</div>';
    echo '</a>';
    echo '</div>';

    return ob_get_clean();
}

//[vd-post]
add_shortcode('vd-post', 'vd_post');
function vd_post($atts)
{
    ob_start();
    global $post;
    $atribut = shortcode_atts(array(
        'category'  => '',
        'limit'     => '3',
        'label'     => '',
        'order'     => 'DESC',
        'orderby'   => 'date',
    ), $atts);
    $category       = $atribut['category'];
    $limit          = $atribut['limit'];
    $order          = $atribut['order'];
    $orderby        = $atribut['orderby'];

    // The Query
    $args = array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => $limit,
        'order'             => $order,
        'orderby'           => $orderby,
    );

    //if set category id
    if ($category) :
        $args['tax_query'] = [[
            'taxonomy'  => 'category',
            'field'     => 'slug',
            'terms'     => $category,
        ]];
    endif;

    //Hits
    if ($orderby == 'hit') {
        $args['meta_key']    = 'hit';
        $args['orderby']     = 'meta_value_num';
    }

    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
        echo '<div class="post-inner">';
        while ($the_query->have_posts()) {
            $the_query->the_post(); ?>
            <div class="row m-0 px-0 py-2 productpost">
                <div class="col-3 col-thumbnail p-0">
                    <?php echo do_shortcode('[ratio-thumbnail class="rounded" size="medium" ratio="4:3"]'); ?>
                </div>
                <div class="col-9 px-2 fw-bold col-content">
                    <div class="post-title"><a class="text-dark" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>

                    <div>
                        <?php if ($orderby == 'hit') : ?>
                            <small class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> <?php echo get_post_meta($post->ID, 'hit', true) . ' views'; ?>
                            </small>
                        <?php else : ?>
                            <small class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                </svg> <?php echo get_the_date('M d, Y', get_the_ID()); ?>
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>';
    } else {
        esc_html_e('Post tidak tersedia');
    }

    /* Restore original Post Data */
    wp_reset_postdata();
    return ob_get_clean();
}

//[velocity-sosmed]
add_shortcode('velocity-sosmed', 'vd_sosmed');
function vd_sosmed()
{
    ob_start();
    $facebook   = velocitytheme_option('sosmed_facebook');
    $instagram  = velocitytheme_option('sosmed_instagram');
    $youtube    = velocitytheme_option('sosmed_youtube');
    $twitter    = velocitytheme_option('sosmed_twitter');
    $tiktok     = velocitytheme_option('sosmed_tiktok'); ?>

    <div class="sosmed">
        <span class="p-2">
            <a href="<?php echo $facebook; ?>">
                <svg class="text-muted bi bi-facebook" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                </svg>
            </a>
        </span>
        <span class="p-2">
            <a href="<?php echo $instagram; ?>">
                <svg class="text-muted bi bi-instagram" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                </svg>
            </a>
        </span>
        <span class="p-2">
            <a href="<?php echo $youtube; ?>">
                <svg class="text-muted bi bi-youtube" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408z" />
                </svg>
            </a>
        </span>
        <span class="p-2">
            <a href="<?php echo $twitter; ?>">
                <svg class="text-muted text-dark bi bi-twitter-x" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                </svg>
            </a>
        </span>
        <span class="p-2">
            <a href="<?php echo $tiktok; ?>">
                <svg class="text-muted bi bi-tiktok" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                </svg>
            </a>
        </span>
    </div>
<?php
    return ob_get_clean();
}
