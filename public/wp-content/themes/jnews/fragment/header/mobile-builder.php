<div class="jeg_navbar_mobile" data-mode="<?php echo esc_attr( get_theme_mod( 'jnews_mobile_menu_follow', 'scroll' ) ); ?>">
    <?php
    $mobile_height  = 0;
    $rows           = array( 'top', 'mid' );
    foreach ( $rows as $row ) {
        if ( jnews_can_render_header( 'mobile', $row ) ) {
            get_template_part( 'fragment/header/mobile-' . $row );

            if ( $row === 'top' ) {
                $mobile_height += 30;
            } else if ( $row === 'mid' ) {
                $mobile_height += (int) get_theme_mod( 'jnews_header_mobile_midbar_height', 60 );
            }

        }
    }
    if ( get_theme_mod( 'jnews_header_mobile_menu_below_enable', false ) ) {
        $mobile_menu_style  = get_theme_mod( 'jnews_header_mobile_menu_style', 'style_1' ) ? 'jeg_mobile_menu_' . get_theme_mod( 'jnews_header_mobile_menu_style', 'style_1' ) : 'jeg_mobile_menu_style_1';
        ?>
            <div class="jeg_navbar_mobile_menu">
                <div class="container">
                    <?php
                        $menu   = wp_nav_menu( [
                            'depth'         => 1,
                            'menu_class'    => $mobile_menu_style,
                            'menu'          => get_theme_mod( 'jnews_header_mobile_menu_below' ),
                        ] );

                        echo $menu;
                    ?>
                </div>
            </div>
        <?php
    }
?>
</div>
<div class="sticky_blankspace" style="height: <?php echo esc_attr($mobile_height) ?>px;"></div>