<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */
get_header();
?>
<div class="wrapper p-0" id="page-wrapper">
    <div class="" id="content">
        <div class="row mx-auto">
            <?php do_action('justg_before_content'); ?>
            <main class="site-main" id="main" role="main">
                <!-- Artikel section -->
                <?php $paged = (get_query_var('page')) ? get_query_var('page') : 1;
                $args = [
                    'posts_per_page' => 8,
                    'post_status'   => 'publish',
                    'post_type' => 'post',
                    'paged' => $paged,
                ];
                $home_query = new WP_Query($args);
                if ($home_query->have_posts()) : ?>
                    <div class="blog-home">
                        <div class="row mx-0">
                            <?php while ($home_query->have_posts()) : $home_query->the_post();
                                get_template_part('loop-templates/content', get_post_format());
                            endwhile; ?>
                        </div>
                    </div>

                <?php
                    // Fungsi pagination
                    echo '<div class="pagination pagi-home">';
                    echo paginate_links([
                        'total' => $home_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => __('&laquo; Prev'),
                        'next_text' => __('Next &raquo;'),
                    ]);
                    echo '</div>';
                else : get_template_part('loop-templates/content', 'none');
                endif;
                wp_reset_postdata(); ?>
            </main><!-- #main -->
            <?php do_action('justg_after_content'); ?>
        </div>
    </div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
