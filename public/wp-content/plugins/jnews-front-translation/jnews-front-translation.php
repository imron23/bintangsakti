<?php
/*
	Plugin Name: JNews - Frontend Translation
	Plugin URI: http://jegtheme.com/
	Description: Easy translation tool for JNews. This plugin will only give option for frontend wording. Backend translation still need to be translated using PO / MO File
	Version: 11.0.1
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_FRONT_TRANSLATION' ) or define( 'JNEWS_FRONT_TRANSLATION', 'jnews-front-translation' );
defined( 'JNEWS_FRONT_TRANSLATION_VERSION' ) or define( 'JNEWS_FRONT_TRANSLATION_VERSION', '11.0.1' );
defined( 'JNEWS_FRONT_TRANSLATION_URL' ) or define( 'JNEWS_FRONT_TRANSLATION_URL', plugins_url( JNEWS_FRONT_TRANSLATION ) );
defined( 'JNEWS_FRONT_TRANSLATION_FILE' ) or define( 'JNEWS_FRONT_TRANSLATION_FILE', __FILE__ );
defined( 'JNEWS_FRONT_TRANSLATION_DIR' ) or define( 'JNEWS_FRONT_TRANSLATION_DIR', plugin_dir_path( __FILE__ ) );
defined( 'JNEWS_FRONT_TRANSLATION_LANG_DIR' ) || define( 'JNEWS_FRONT_TRANSLATION_LANG_DIR', JNEWS_FRONT_TRANSLATION_DIR . 'languages' );

global $pagenow;

/**
 * Get jnews option
 *
 * @param $setting
 * @param $default
 * @return mixed
 */
if ( ! function_exists( 'jnews_get_option' ) ) {
	function jnews_get_option( $setting, $default = null ) {
		$options = get_option( 'jnews_option', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}
		return $value;
	}
}

/**
 * Translation Panel
 */
add_action( 'after_setup_theme', 'jnews_translation_panel' );

if ( ! function_exists( 'jnews_translation_panel' ) ) {
	function jnews_translation_panel() {
		require 'class.jnews-translation-option.php';
		require 'class.jnews-translation-dashboard.php';
		JNews_Translation_Option::instance();
		JNews_Translation_Dashboard::get_instance();
	}
}

/**
 * Translation Method
 */
if ( ! is_admin() || 'post.php' === $pagenow ) {
	add_action( 'init', 'jnews_plugin_translate' );

	if ( ! function_exists( 'jnews_plugin_translate' ) ) {
		function jnews_plugin_translate() {
			// Print Translation
			remove_action( 'jnews_print_translation', 'jnews_print_main_translation', 10 );
			add_action( 'jnews_print_translation', 'jnews_print_alt_translation', null, 3 );

			// Return Translation
			remove_filter( 'jnews_return_translation', 'jnews_return_main_translation', 10 );
			add_filter( 'jnews_return_translation', 'jnews_return_alt_translation', null, 4 );
		}
	}

	if ( ! function_exists( 'jnews_print_alt_translation' ) ) {
		function jnews_print_alt_translation( $string, $domain, $key ) {
			if ( vp_option( 'jnews_translate.enable_translation', true ) ) {
				echo esc_html( vp_option( 'jnews_translate.' . $key, $string ) );
			} else {
				esc_html_e( $string, $domain );
			}
		}
	}


	if ( ! function_exists( 'jnews_return_alt_translation' ) ) {
		function jnews_return_alt_translation( $string, $domain, $key, $escape = true ) {
			if ( vp_option( 'jnews_translate.enable_translation', true ) ) {
				if ( $escape ) {
					return esc_html( vp_option( 'jnews_translate.' . $key, $string ) );
				} else {
					return vp_option( 'jnews_translate.' . $key, $string );
				}
			} else {
				if ( $escape ) {
					return esc_html__( $string, $domain );
				} else {
					return __( $string, $domain );
				}
			}
		}
	}
}

/**
 * Load Text Domain
 */

function jnews_front_translation_load_textdomain() {
	load_plugin_textdomain( JNEWS_FRONT_TRANSLATION, false, JNEWS_FRONT_TRANSLATION_LANG_DIR );
}

jnews_front_translation_load_textdomain();
