<?php

if ( ! function_exists( 'jnews_get_option' ) ) {
	/**
	 * Get jnews option
	 *
	 * @param $setting
	 * @param $default
	 *
	 * @return mixed
	 */
	function jnews_get_option( $setting, $default = null ) {
		$options = get_option( 'jnews_option', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return $value;
	}
}
