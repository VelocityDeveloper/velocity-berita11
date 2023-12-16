<?php
function module_vdposts($args = null, $style = null)
{

    if (isset($args['sortby'])) {
        if ($args['sortby'] == 'view') {
            $args['orderby']    = 'meta_value_num';
            $args['meta_key']   = 'hit';
        }
        unset($args['sortby']);
    }

    // The Query
    $the_query = new WP_Query($args);

    // The Loop
    if ($the_query->have_posts()) {
        echo '<div class="module-vdposts module-vdposts-' . $style . '">';
        while ($the_query->have_posts()) {
            $the_query->the_post();

            switch ($style) {
                case 'posts1':
?>
                    <div class="posts-item pb-1 mb-2">
                        <div class="ratio ratio-16x9 bg-light border border-4 mb-2">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php echo get_the_permalink(); ?>">
                                    <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(), 'medium'); ?>" alt="" loading="lazy">
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="post-text">
                            <a class="fw-bold mb-2 d-block h6" href="<?php echo get_the_permalink(); ?>">
                                <?php echo get_the_title(); ?>
                            </a>
                            <div class="post-excerpt mb-2 text-muted">
                                <small>
                                    <?php echo vdberita_limit_text(strip_tags(get_the_content()), 25); ?>
                                </small>
                            </div>
                            <div class="py-1 px-2 border-bottom border-top text-muted bg-light">
                                <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts2':

                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <div class="ratio ratio-1x1 bg-light border border-4">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php echo get_the_permalink(); ?>">
                                            <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-8 col-md-9 ps-0">
                                <div class="post-date">
                                    <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                                </div>
                                <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                    <?php echo vdberita_limit_text(get_the_title(), 8); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'carousel':
                ?>
                    <div class="carousel-post-item px-2">
                        <div class="card p-2 border-secondary-subtle shadow-sm bg-light">
                            <div class="row">
                                <div class="col-4">
                                    <div class="ratio ratio-1x1 bg-light">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img data-flickity-lazyload="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col ps-0">
                                    <div class="post-date">
                                        <small> <?php echo get_the_date(); ?> </small>
                                    </div>
                                    <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'image':
                ?>
                    <div class="ratio ratio-1x1 bg-light mb-2">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php echo get_the_permalink(); ?>">
                                <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                            </a>
                        <?php endif; ?>
                    </div>
                <?php
                    break;
                case 'posts3':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="ratio ratio-1x1 bg-light border border-4">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php echo get_the_permalink(); ?>">
                                            <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="post-date">
                                    <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                                </div>
                                <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                    <?php echo vdberita_limit_text(get_the_title(), 8); ?>
                                </a>
                                <div class="post-excerpt">
                                    <small>
                                        <?php echo vdberita_limit_text(strip_tags(get_the_content()), 5); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts-head-footer':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="ratio ratio-1x1 bg-light border border-4">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php echo get_the_permalink(); ?>">
                                            <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-8 ps-0">
                                <div class="post-date">
                                    <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                                </div>
                                <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                                    <?php echo vdberita_limit_text(get_the_title(), 8); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                    break;
                case 'posts4':
                    echo '<a class="d-flex w-100 border-bottom pb-1 mb-1" href="' . get_the_permalink() . '">';
                    echo '<i class="fa fa-file-text-o mt-1 me-2"></i>';
                    echo '<span>' . get_the_title() . '</span>';
                    echo '</a>';
                ?>
                <?php
                    break;
                case 'posts5':
                ?>
                    <div class="posts-item border-bottom pb-1 mb-2">
                        <div class="post-date">
                            <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                        </div>
                        <a class="fw-bold" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                            <?php echo vdberita_limit_text(get_the_title(), 9); ?>
                        </a>
                    </div>
                <?php
                    break;
                case 'title-half':
                    echo '<a class="d-inline-block pb-1 mb-1" style="width:49%;" href="' . get_the_permalink() . '">';
                    echo '<span>' . get_the_title() . '</span>';
                    echo '</a>';
                ?>
                <?php
                    break;
                case 'heading':
                    echo '<h3><a class="d-flex w-100 pb-1 mb-1" href="' . get_the_permalink() . '">';
                    echo '<span>' . get_the_title() . '</span>';
                    echo '</a></h3>';
                    echo '<div class="post-excerpt">';
                    echo '<small>';
                    echo vdberita_limit_text(strip_tags(get_the_content()), 25);
                    echo '</small>';
                    echo '</div>';
                ?>
                <?php
                    break;
                case 'homespecial':
                ?>
                    <div class="posts-item bg-white p-2 shadow mb-2 position-relative">
                        <span class="position-absolute z-1 top-0 start-0 translate-middle-y">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-pin-angle-fill text-warning" viewBox="0 0 16 16">
                                <path d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a5.927 5.927 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707-.195-.195.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a5.922 5.922 0 0 1 1.013.16l3.134-3.133a2.772 2.772 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146z" />
                            </svg>
                        </span>
                        <div class="ratio ratio-16x9 bg-light mb-2">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php echo get_the_permalink(); ?>">
                                    <img src="<?php echo wp_get_attachment_thumb_url(get_post_thumbnail_id()); ?>" alt="" loading="lazy">
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="post-text">
                            <div class="py-2 px-1 text-muted">
                                <small> <?php echo get_the_date(); ?> / <?php echo justg_get_hit(); ?> views </small>
                            </div>
                            <a class="fw-bold mb-2 d-block h6" href="<?php echo get_the_permalink(); ?>">
                                <?php echo get_the_title(); ?>
                            </a>
                        </div>
                    </div>
<?php
                    break;
                default:
                    echo '<div class="posts-item border-bottom pb-1 mb-2">';
                    echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                    echo '</div>';
                    break;
            }
        }
        echo '</div>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}
