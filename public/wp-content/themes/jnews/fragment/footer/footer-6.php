<div class="jeg_footer jeg_footer_6 <?php echo esc_attr( get_theme_mod('jnews_footer_scheme', 'normal') ); ?>">
    <div class="jeg_footer_container <?php echo esc_attr( get_theme_mod('jnews_footer_force_fullwidth') ? 'jeg_container_full' : 'jeg_container' ); ?>">

        <div class="jeg_footer_content">
            <div class="container">
                <div class="jeg_footer_primary clearfix">
                    <?php jnews_widget_area( 'footer-widget-1' ); ?>
                </div>
            </div>
        </div>

        <?php
            $order  = apply_filters( 'jnews_footer_social_feed_order', [ 'instagram', 'tiktok' ] );

            foreach ( $order as $feed ) {
                ?>
                    <div class="jeg_footer_<?php echo $feed; ?>_wrapper jeg_container">
                        <?php do_action('jnews_render_'. $feed .'_feed_footer'); ?>
                    </div>
                <?php
            }
        ?>

        <?php if(get_theme_mod('jnews_footer_show_secondary', true)) : ?>

        <div class="jeg_footer_bottom">
            <div class="container">

                <!-- secondary footer right -->
                <div class="footer_right">

                    <?php if(get_theme_mod('jnews_footer_copyright_position', 'left') === 'right') : ?>
                        <p class="copyright"> <?php echo jnews_get_footer_copyright(); ?> </p>
                    <?php endif; ?>

                    <?php if(get_theme_mod('jnews_footer_menu_position', 'right') === 'right') :
                        jnews_menu()->footer_navigation();
                    endif; ?>

                    <?php do_action( 'jnews_footer_social', 'right' ); ?>

                </div>

                <!-- secondary footer left -->
                <?php do_action( 'jnews_footer_social', 'left' ); ?>

                <?php if(get_theme_mod('jnews_footer_menu_position', 'right') === 'left') :
                    jnews_menu()->footer_navigation();
                endif; ?>

                <?php if(get_theme_mod('jnews_footer_copyright_position', 'left') === 'left') : ?>
                    <p class="copyright"> <?php echo jnews_get_footer_copyright(); ?> </p>
                <?php endif; ?>

            </div>
        </div>

        <?php endif; ?>

    </div>
</div><!-- /.footer -->