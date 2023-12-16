<footer class="site-footer bg-light mb-3 p-0" id="colophon">
    <div class="container"><?php echo vdbanner('banner_footer', 'text-center'); ?></div>
    <div class="container">
        <div class="card bg-transparent m-0 rounded-0 border-light border-0">
            <div class="velocity-footer">
                <div class="row footer-widget text-start mx-auto p-0 pt-md-4">
                    <?php for ($x = 1; $x <= 4; $x++) {
                        if (is_active_sidebar('footer-widget-' . $x)) : ?>
                            <div class="col-md">
                                <?php dynamic_sidebar('footer-widget-' . $x); ?>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row m-0 align-items-center border-top">
            <div class="col-md-9 p-2">
                <div class="secondary-menuset py-1">
                    <nav id="secondary-nav" class="p-0">
                        <div class="menu-second">
                            <!-- The WordPress Menu goes here -->
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location'  => 'secondary',
                                    'container_class' => '',
                                    'container_id'    => '',
                                    'menu_class'      => 'navbar-nav d-inline-block justify-content-end flex-grow-1',
                                    'fallback_cb'     => '',
                                    'menu_id'         => 'secondary',
                                    'depth'           => 4,
                                    'walker'          => new justg_WP_Bootstrap_Navwalker(),
                                )
                            );
                            ?>
                        </div><!-- .menu-utama -->
                    </nav><!-- .site-navigation -->
                </div><!-- .secondary-menuset -->
                <div class="site-info px-2">
                    <small>
                        Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
                    </small>
                    <br>
                    <small class="opacity-50">
                        Design by <a class="text-muted" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
                    </small>
                </div>
            </div>
            <div class="col-md-3 p-2 text-md-end"><?php echo do_shortcode('[velocity-sosmed]'); ?></div>
        </div>
    </div>
</footer>