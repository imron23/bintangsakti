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

<div class="jeg_footer jeg_footer_5 <?php echo esc_attr( get_theme_mod('jnews_footer_scheme', 'normal') ); ?>">
    <div class="jeg_footer_container <?php echo esc_attr( get_theme_mod('jnews_footer_force_fullwidth', false) ? 'jeg_container_full' : 'jeg_container' ); ?>">

        <div class="jeg_footer_content">
            <div class="container">

                <?php
                    if ( get_theme_mod( 'jnews_footer_show_social', true ) ) {
                        do_action( 'jnews_footer_5_social' );
                    }
                ?>

                <div class="jeg_footer_primary clearfix">
                    <!-- Footer Widget: Column 1 -->
                    <div class="col-md-4 footer_column">
                        <?php jnews_widget_area( 'footer-widget-1' ); ?>
                    </div>

                    <!-- Footer Widget: Column 2 -->
                    <div class="col-md-4 footer_column">
                        <?php jnews_widget_area( 'footer-widget-2' ); ?>
                    </div>

                    <!-- Footer Widget: Column 3 -->
                    <div class="col-md-4 footer_column">
                        <?php jnews_widget_area( 'footer-widget-3' ); ?>
                    </div>
                </div>

                <?php if(get_theme_mod('jnews_footer_show_secondary', true)) : ?>

                <div class="jeg_footer_secondary clearfix">
                    <div class="footer_center">
                        <p class="copyright"> <?php echo jnews_get_footer_copyright(); ?></p>
                    </div>
                </div>

                <?php endif; ?>

            </div>
        </div>

    </div>
</div><!-- /.footer -->