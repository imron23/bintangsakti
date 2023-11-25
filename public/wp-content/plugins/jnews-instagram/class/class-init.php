<?php

namespace JNEWS_INSTAGRAM;

use JNEWS_INSTAGRAM\API\Instagram_Api;
use JNEWS_INSTAGRAM\Customizer\Customizer;
use JNEWS_INSTAGRAM\Module\Module;

class Init {
	/**
	 * Instance of Init
	 *
	 * @var Init
	 */
	private static $instance;

	/**
	 * Hold instance
	 *
	 * @var array
	 */
	private $object = array();

	/**
	 * Singleton page of Init class
	 *
	 * @return Init
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Init constructor.
	 */
	private function __construct() {
		$this->load_plugin_text_domain();
		$this->load_helper();
		$this->setup_init();
		$this->setup_hook();
	}

	/**
	 * Setup init
	 */
	private function setup_init() {
		Customizer::get_instance();
		Instagram_Api::get_instance();
		Module::get_instance();
	}

	/**
	 * Load plugin text domain
	 */
	private function load_plugin_text_domain() {
		load_plugin_textdomain( JNEWS_INSTAGRAM, false, basename( JNEWS_INSTAGRAM_DIR ) . '/languages/' );
	}

	/**
	 * Setup hook
	 */
	private function setup_hook() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_script' ), 100 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_script' ), 100 );
		add_action( 'jnews_render_instagram_feed_header', array( $this, 'jnews_instagram_feed_header' ) );
		add_action( 'jnews_render_instagram_feed_footer', array( $this, 'jnews_instagram_feed_footer' ) );
		add_action( 'wp_ajax_jnews_instagram', array( $this, 'jnews_instagram_purge_cache' ) );

		add_filter( 'jnews_instagram_video', array( $this, 'instagram_video_tag' ), 10, 2 );
	}

	/**
	 * Load Script
	 */
	public function load_script() {
		if ( is_admin() ) {
			$handle = 'jnews-widget';
			wp_localize_script( $handle, 'jnewsinstagramoption', $this->localize_script() );
		} else {
			$dependencies = array();
			if ( SCRIPT_DEBUG || get_theme_mod( 'jnews_load_necessary_asset', false ) ) {
				wp_enqueue_style( 'jnews-instagram', JNEWS_INSTAGRAM_URL . '/assets/css/plugin.css', null, JNEWS_INSTAGRAM_VERSION );
				$dependencies = array( 'waypoint' );
			}
			wp_register_script( 'jnews-instagram', JNEWS_INSTAGRAM_URL . '/assets/js/plugin.js', $dependencies, JNEWS_INSTAGRAM_VERSION, true );
		}
	}

	/**
	 * Hold localize script
	 *
	 * @return array
	 */
	public function localize_script() {
		$option                       = array();
		$option['instagram_callback'] = admin_url( 'admin.php?page=sb-instagram-feed' );

		return $option;
	}

	/**
	 * Render feed footer
	 *
	 * @return mixed
	 */
	public function jnews_instagram_feed_footer() {
		return $this->jnews_instagram_feed( 'footer' );
	}

	/**
	 * Render feed
	 *
	 * @param bool $type
	 *
	 * @return
	 */
	private function jnews_instagram_feed( $type = false ) {
		if ( $type && in_array( $type, array( 'footer', 'header' ), true ) ) {
			$option = jnews_get_option( 'instagram_feed_enable', 'hide' );

			if ( 'only_' . $type === $option || 'both' === $option ) {
				$param                     = array(
					'row'      => jnews_get_option( 'footer_instagram_row', 1 ),
					'column'   => jnews_get_option( 'footer_instagram_column', 8 ),
					'username' => jnews_get_option( 'footer_instagram_username', '' ),
					'video'    => jnews_get_option( 'footer_instagram_video', 'thumbnail' ),
					'sort'     => jnews_get_option( 'footer_instagram_sort_type', 'most_recent' ),
					'hover'    => jnews_get_option( 'footer_instagram_hover_style', 'zoom' ),
					'newtab'   => jnews_get_option( 'footer_instagram_newtab', null ) ? 'target=\'_blank\'' : '',
					'follow'   => jnews_get_option( 'footer_instagram_follow_button', null ),
					'method'   => jnews_get_option( 'instagram_feed_method', 'username' ),
					'token'    => jnews_get_option( 'footer_instagram_access_token', null ),
				);
				$this->object['instagram'] = new Instagram( $param );

				return $this->object['instagram']->generate_element();
			}
		}
	}

	/**
	 * Render feed header
	 *
	 * @return mixed
	 */
	public function jnews_instagram_feed_header() {
		return $this->jnews_instagram_feed( 'header' );
	}

	/**
	 * Load helper file
	 */
	public function load_helper() {
		require_once JNEWS_INSTAGRAM_DIR . 'class/helper.php';
	}

	/**
	 * Purge cache
	 *
	 * @return
	 */
	public function jnews_instagram_purge_cache() {
		$instagram = Instagram_Api::get_instance();
		$instagram->get_data( true );
	}


	/**
	 * Handle Insagram video tag
	 *
	 * @return string
	 */
	public function instagram_video_tag( $url, $caption ) {
		$mechanism = get_theme_mod( 'jnews_image_load', 'lazyload' );
		return "<div class='thumbnail-container size-1000'>
            <video " . ( $mechanism === 'lazyload' ? 'class="lazyload-instavid"' : '' ) . " preload='none' data-poster='" . apply_filters( 'jnews_empty_image', '' ) . "' width='100%' muted='' loop=''>
                <source data-src='{$url}' type='video/mp4'>
                {$caption}
            </video>
        </div>";
	}
}
