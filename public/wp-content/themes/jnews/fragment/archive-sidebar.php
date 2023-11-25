<div class="jeg_sidebar <?php echo esc_attr( $sidebar['position-sidebar'] . ' ' . $sidebar['sticky-sidebar'] ); ?> col-sm-<?php echo esc_attr($sidebar['width-sidebar']); ?>">
    <?php
	if ( $sidebar['is_sticky'] ) {
		echo '<div class="jegStickyHolder"><div class="theiaStickySidebar">';
		jnews_widget_area( $sidebar['content-sidebar'] );
		echo '</div></div>';
	} else {
		jnews_widget_area( $sidebar['content-sidebar'] );
	}
	?>
</div>
