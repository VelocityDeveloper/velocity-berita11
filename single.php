<?php

/**
 * The template for displaying all single posts
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container  = velocitytheme_option('justg_container_type', 'container');
$full_url   = get_the_post_thumbnail_url(get_the_ID(), 'full');
$format     = get_post_format() ?: 'standard';
?>

<div class="wrapper" id="single-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="card-breadcrumbs bg-light pt-2 px-3 mb-3">
            <?php echo justg_breadcrumb(); ?>
        </div>

        <div class="row">

            <!-- Do the left sidebar check -->
            <?php do_action('justg_before_content'); ?>

            <main class="site-main col order-2" id="main">

                <?php

                while (have_posts()) {
                    the_post();
                ?>

                    <?php the_title('<h1 class="entry-title h4 fw-bold">', '</h1>'); ?>


                    <div class="post-info d-flex mt-2 justify-content-between align-items-center py-1 px-2 text-muted mb-3">
                        <div>
                            <small>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z" />
                                </svg> <?php echo get_the_author(); ?>
                            </small>
                            <small class="ms-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                </svg> <?php echo get_the_date('M d, Y', get_the_ID()); ?>
                            </small>
                            <small class="ms-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg> <?php echo get_post_meta($post->ID, 'hit', true) . ' views'; ?>
                            </small>
                        </div>
                    </div>

                    <div class="entry-content">
                        <div class="pb-3">
                            <?php echo vdbanner('banner_single1', 'text-center'); ?>
                        </div>
                        <?php
                        if ($full_url && $format !== 'video') {
                            echo '<div class="pb-2 text-center text-muted">';
                            echo '<div><img class="img-fluid w-100 mb-2" src="' . $full_url . '" loading="lazy"/></div>';
                            echo the_post_thumbnail_caption();
                            echo '</div>';
                        }
                        ?>

                        <?php the_content(); ?>
                        <div class="pb-3">
                            <?php echo vdbanner('banner_single2', 'text-center'); ?>
                        </div>

                        <div class="tag-singles fs-6">
                            <?php $gettags = get_the_tags(get_the_ID()); ?>
                            <?php if ($gettags) : ?>
                                <span class="badge bg-dark rounded-0 p-2">Tags :</span>
                                <?php foreach ($gettags as $index => $tag) : ?>
                                    <?php echo $index === 0 ? '' : ' '; ?>
                                    <div class="badge bg-theme rounded-0 p-2">
                                        <a class="text-white fw-lighter" href="<?php echo get_tag_link($tag->term_id); ?>"> <?php echo $tag->name; ?> </a>
                                    </div>
                                    <?php if ($index > 1) {
                                        break;
                                    } ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div><!-- .entry-content -->

                    <div class="related-post">
                        <div class="related-post-title border-bottom border-color-theme border-4 mb-2">
                            <span class="fw-bold py-3 h6 m-0 d-inline-block">Related Post "<?php echo get_the_title(); ?>"</span>
                        </div>
                        <div class="related-post py-2 overflow-hidden">
                            <?php
                            $related = get_posts([
                                'category__in' => wp_get_post_categories($post->ID),
                                'numberposts' => 3,
                                'post__not_in' => array($post->ID),
                            ]);
                            if ($related)
                                echo '<div class="row m-0">';
                            foreach ($related as $post) :
                                setup_postdata($post); ?>
                                <div class="col-md-4 my-2 px-md-2 px-0 bg-light">
                                    <div class="post-images"><?php echo do_shortcode('[ratio-thumbnail class="rounded-0" size="medium" ratio="3:2"]'); ?></div>
                                    <div class="post-title p-2"><?php echo get_the_title(); ?></div>
                                </div>
                            <?php
                            endforeach;
                            echo '</div>';
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>

                    <div class="single-post-nav d-md-flex justify-content-between border-top border-bottom pt-1 my-3">
                        <div class="share-post py-2">
                            <?php echo justg_share(); ?>
                        </div>
                        <div class="nav-post py-2">
                            <div class="btn-group" role="group" aria-label="Navigation Post">
                                <?php
                                $prev_post = get_adjacent_post(false, '', true);
                                if (!empty($prev_post)) {
                                    echo '<a href="' . get_permalink($prev_post->ID) . '" class="btn btn-sm btn-light border" title="' . $prev_post->post_title . '">Prev</a>';
                                }
                                $next_post = get_adjacent_post(false, '', false);
                                if (!empty($next_post)) {
                                    echo '<a href="' . get_permalink($next_post->ID) . '" class="btn btn-sm btn-light border" title="' . $next_post->post_title . '">Next</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                <?php

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        do_action('justg_before_comments');
                        comments_template();
                        do_action('justg_after_comments');
                    }
                }
                ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
