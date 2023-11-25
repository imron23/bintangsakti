<?php
/**
 * JNews_Translation_Dashboard Class
 *
 * @author Jegtheme
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Class JNews_Translation_Dashboard
 */
class JNews_Translation_Dashboard {

	/**
	 * Instance of JNews_Translation_Dashboard class
	 *
	 * @var JNews_Translation_Dashboard
	 */
	private static $instance;

	/**
	 * Register Location
	 *
	 * @var array
	 */
	private $register_location = array(
		'toplevel_page_jnews',
		'appearance_page_jnews',
	);

	/**
	 * Instance of JNews_Translation_Dashboard
	 *
	 * @return JNews_Translation_Dashboard
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
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );
	}

	/**
	 * Enqueue scripts
	 *
	 * @param string $hook .
	 */
	public function enqueue_scripts( $hook ) {
		if ( in_array( $hook, $this->register_location, true ) ) {
			$include = include JNEWS_FRONT_TRANSLATION_DIR . '/lib/dependencies/translation-dashboard.asset.php';
			wp_enqueue_script(
				'translation-dashboard',
				JNEWS_FRONT_TRANSLATION_URL . '/assets/js/admin/translation-dashboard.js',
				$include['dependencies'],
				JNEWS_FRONT_TRANSLATION_VERSION,
				true
			);
			wp_localize_script( 'translation-dashboard', 'JNewsTranslationDashboard', self::jnews_dashboard() );
			wp_set_script_translations( 'translation-dashboard', 'jnews-front-translation', JNEWS_FRONT_TRANSLATION_LANG_DIR );

			wp_enqueue_style(
				'translation-dashboard',
				JNEWS_FRONT_TRANSLATION_URL . '/assets/css/admin/translation-dashboard.css',
				null,
				JNEWS_FRONT_TRANSLATION_VERSION
			);
		}
	}

	/**
	 * JNews Dashboard Config
	 *
	 * @return array
	 */
	public static function jnews_dashboard() {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
		$config           = array();

		$config['options']   = $revert_dashboard ? array() : JNews_Translation_Option::theme_option( true )->panel_data();
		$config['domainURL'] = home_url();
		$config['nonce']     = wp_create_nonce( 'wp_rest' );

		return $config;
	}
}
