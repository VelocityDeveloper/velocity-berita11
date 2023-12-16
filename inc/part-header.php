<?php
$bannertop1 = velocitytheme_option('banner_header1');
?>
<div class="header-position bg-white">
    <div class="container primary-menuset">
        <nav id="main-nav" class="navbar navbar-expand-md navbar-light p-md-0 p-2" aria-labelledby="main-nav-label">
            <div class="menu-utama">
                <div class="border rounded">
                    <button class="navbar-toggler p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

                    <div class="offcanvas-header justify-content-end">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div><!-- .offcancas-header -->

                    <!-- The WordPress Menu goes here -->
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'offcanvas-body',
                            'container_id'    => '',
                            'menu_class'      => 'navbar-nav justify-content-end flex-grow-1 pe-3',
                            'fallback_cb'     => '',
                            'menu_id'         => 'main-menu',
                            'depth'           => 4,
                            'walker'          => new justg_WP_Bootstrap_Navwalker(),
                        )
                    );
                    ?>
                </div><!-- .offcanvas -->
            </div><!-- .menu-utama -->
        </nav><!-- .site-navigation -->
    </div><!-- .primary-menuset -->
</div>

<div class="container my-3">
    <div class="row m-0 align-items-center">
        <div class="col-md-4">
            <?php if (!has_custom_logo()) :
                if (is_front_page() && is_home()) : ?>
                    <h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                    <a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>" itemprop="url"><?php bloginfo('name'); ?></a>
                <?php endif;
            else :
                $sitelogo = velocitytheme_option('custom_logo'); ?>
                <div class="position-relative text-center p-md-0 pb-2">
                    <?php if ($sitelogo) : ?>
                        <a href="<?php echo get_home_url(); ?>">
                            <img src="<?php echo wp_get_attachment_image_url($sitelogo, 'full'); ?>" alt="Site Logo" loading="lazy">
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <?php if ($bannertop1) : ?>
                <div class="banner-header pb-2">
                    <?php echo vdbanner('banner_header1', 'text-end'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div><!-- .container -->