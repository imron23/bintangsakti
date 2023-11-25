<?php
	$social_array = jnews_get_author_social();

	$socials = '';

if ( is_single() ) {
	$author_id = get_post_field( 'post_author', get_the_ID() );
} else {
	$author_id = get_queried_object()->ID;
}

foreach ( $social_array as $key => $value ) {
	if ( get_the_author_meta( $key, $author_id ) ) {
		if ( $value === 'fa-twitter' ) {
			$icon = '<i class="fa ' . esc_attr( $value ) . ' jeg-icon icon-twitter">' . jnews_get_svg( $key ) . '</i>';
		} else {
			$icon = strpos( $value, 'jeg-icon' ) !== false ? '<i	 class="' . $value . '">' . jnews_get_svg( $key ) . '</i>' : '<i class="fa ' . esc_attr( $value ) . '"></i>';
		}
		$socials = $socials . "<a target='_blank' href='" . get_the_author_meta( $key, $author_id ) . "' class='" . $key . "'>" . $icon . '</a>';
	}
}

	echo jnews_sanitize_by_pass( $socials );
