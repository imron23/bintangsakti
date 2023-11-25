<?php
/**
 * JNews_Translation_Option
 *
 * @author Jegtheme
 * @package JNews_Translation_Option
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class JNews_Translation_Option
 */
class JNews_Translation_Option {

	/**
	 * Instance of JNews_Translation_Option
	 *
	 * @var JNews_Translation_Option
	 */
	private static $instance;

	/**
	 * Singleton page of JNews_Translation_Option class
	 *
	 * @return JNews_Translation_Option
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Construct of class JNews_Translation_Option
	 */
	private function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		if ( is_admin() ) {
			$vp_option = apply_filters( 'vp_option_key', 'jnews_translate' );

			add_filter( 'jnews_admin_menu', array( $this, 'admin_menu' ) );
			add_filter( 'jnews_admin_slug', array( $this, 'admin_slug' ) );
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			add_action( 'init', array( $this, 'load_assets' ) );
			add_action( 'wp_ajax_vp_ajax_' . $vp_option . '_save', array( $this, 'fix_duplicate' ), 9 );
			add_action( 'wp_ajax_vp_ajax_' . $vp_option . '_save', array( $this, 'remove_fix_duplicate' ), 11 );
		}

		$this->theme_option();
	}

	/**
	 * Register API
	 */
	public function register_routes() {
		// Panel.
		register_rest_route(
			'jnews-front-translation/v1',
			'savePanelOptions',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_panel_options' ),
				'permission_callback' => array( $this, 'permission_manage_options' ),
			)
		);
		register_rest_route(
			'jnews-front-translation/v1',
			'restorePanelOptions',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'restore_panel_options' ),
				'permission_callback' => array( $this, 'permission_manage_options' ),
			)
		);
		register_rest_route(
			'jnews-front-translation/v1',
			'importPanelOptions',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'import_panel_options' ),
				'permission_callback' => array( $this, 'permission_manage_options' ),
			)
		);
		register_rest_route(
			'jnews-front-translation/v1',
			'exportPanelOptions',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'export_panel_options' ),
				'permission_callback' => array( $this, 'permission_manage_options' ),
			)
		);
	}

	/**
	 * Check permission manage options
	 *
	 * @return bool
	 */
	public function permission_manage_options() {
		return function_exists( 'jnews_permission_manage_options' ) ? jnews_permission_manage_options() : current_user_can( 'manage_options' );
	}

	/**
	 * Save Panel Options
	 *
	 * @param \WP_REST_Request $request Core class used to implement a REST request object.
	 *
	 * @return \WP_REST_Response|array
	 */
	public function save_panel_options( $request ) {
		if ( class_exists( '\JNews\Util\RestAPI' ) ) {
			$rest_api = JNews\Util\RestAPI::instance();
			return $rest_api->save_panel_options( $request );
		}
		return new \WP_REST_Response(
			array(
				'message' => esc_html__( 'You are not allowed to perform this action.', 'jnews-front-translation' ),
			),
			500
		);
	}

	/**
	 * Restore Panel Options
	 *
	 * @param \WP_REST_Request $request Core class used to implement a REST request object.
	 *
	 * @return \WP_REST_Response|array
	 */
	public function restore_panel_options( $request ) {
		if ( class_exists( '\JNews\Util\RestAPI' ) ) {
			$rest_api = JNews\Util\RestAPI::instance();
			return $rest_api->restore_panel_options( $request );
		}
		return new \WP_REST_Response(
			array(
				'message' => esc_html__( 'You are not allowed to perform this action.', 'jnews-front-translation' ),
			),
			500
		);
	}

	/**
	 * Import Panel Options
	 *
	 * @param \WP_REST_Request $request Core class used to implement a REST request object.
	 *
	 * @return \WP_REST_Response|array
	 */
	public function import_panel_options( $request ) {
		if ( class_exists( '\JNews\Util\RestAPI' ) ) {
			$rest_api = JNews\Util\RestAPI::instance();
			return $rest_api->import_panel_options( $request );
		}
		return new \WP_REST_Response(
			array(
				'message' => esc_html__( 'You are not allowed to perform this action.', 'jnews-front-translation' ),
			),
			500
		);
	}

	/**
	 * Export Panel Options
	 *
	 * @param \WP_REST_Request $request Core class used to implement a REST request object.
	 *
	 * @return \WP_REST_Response|array
	 */
	public function export_panel_options( $request ) {
		if ( class_exists( '\JNews\Util\RestAPI' ) ) {
			$rest_api = JNews\Util\RestAPI::instance();
			return $rest_api->export_panel_options( $request );
		}
		return new \WP_REST_Response(
			array(
				'message' => esc_html__( 'You are not allowed to perform this action.', 'jnews-front-translation' ),
			),
			500
		);
	}

	public function load_assets() {
		$slug = apply_filters( 'jnews_get_admin_slug', '' );
		if ( is_array( $slug ) && ! empty( $slug ) ) {
			if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === $slug['translation'] ) {
				wp_enqueue_script( 'jnews-front-translation', JNEWS_FRONT_TRANSLATION_URL . '/assets/js/plugin.js', null, JNEWS_FRONT_TRANSLATION_VERSION, true );
			}
		}
	}

	public function fix_duplicate() {
		add_filter( 'jnews_vp_multiple_value_force_first_value', '__return_true' );
	}

	public function remove_fix_duplicate() {
		remove_filter( 'jnews_vp_multiple_value_force_first_value', '__return_true' );
	}

	public function admin_notice() {
		$slug = apply_filters( 'jnews_get_admin_slug', '' );

		if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] === $slug['translation'] ) {
			// polylang
			if ( function_exists( 'pll_current_language' ) ) {
				$current_language = pll_current_language( 'name' );
				if ( empty( $current_language ) ) {
					$current_language = pll_default_language( 'name' );
				}

				printf(
					'<div class="updated"><p>%s : <strong>%s</strong></p></div>',
					esc_html__( 'Frontend Translation Language', 'jnews' ),
					$current_language
				);
			}

			// wpml
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
				if ( defined( 'ICL_LANGUAGE_NAME' ) ) {
					printf(
						'<div class="updated"><p>%s : <strong>%s</strong></p></div>',
						esc_html__( 'Frontend Translation Language', 'jnews' ),
						ICL_LANGUAGE_NAME
					);
				}
			}
		}
	}

	public function admin_slug( $slug ) {
		$translation_slug = array(
			'translation' => 'jnews_translation',
		);

		return array_merge( $translation_slug, $slug );
	}

	public function admin_menu( $menu ) {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
		$admin_url        = defined( 'JNEWS_ESSENTIAL' ) ? 'admin.php' : 'themes.php';
		$slug             = apply_filters( 'jnews_get_admin_slug', '' );

		$translation_menu = array(
			array(
				'title'        => esc_html__( 'Translate Frontend', 'jnews-front-translation' ),
				'menu'         => esc_html__( 'Translate Frontend', 'jnews-front-translation' ),
				'slug'         => $revert_dashboard ? $slug['translation'] : $slug['dashboard'] . '&path=' . $slug['translation'],
				'action'       => admin_url( $admin_url . '?page=jnews&path=' . $slug['translation'] ),
				'priority'     => 54,
				'show_on_menu' => $revert_dashboard ? false : true,
				'plugin'       => true,
			),
		);

		return array_merge( $menu, $translation_menu );
	}

	public static function translation_slug() {
		$adminslug = apply_filters( 'jnews_get_admin_slug', '' );
		return is_array( $adminslug ) && isset( $adminslug['translation'] ) ? $adminslug['translation'] : '';
	}

	/**
	 * Theme Option
	 *
	 * @param boolean $return Return the option.
	 *
	 * @return \JNews\Util\Api\Panel
	 */
	public static function theme_option( $return = false ) {
		$option           = (object) array();
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
		if ( $revert_dashboard ) {
			if ( class_exists( '\VP_Option' ) ) {
				$dashboard_option = self::dashboard_option();
				$translation_slug = self::translation_slug();
				$option           =
					new \VP_Option(
						array(
							'is_dev_mode'           => false,
							'option_key'            => 'jnews_translate',
							'page_slug'             => $translation_slug,
							'menu_page'             => 'jnews',
							'template'              => $dashboard_option,
							'use_auto_group_naming' => true,
							/**
							 * @see \JNews\Util\ValidateLicense::is_license_validated
							 * @since 8.0.0
							 */
							'use_util_menu'         => function_exists( 'jnews_is_active' ) && jnews_is_active()->is_license_validated(),
							'minimum_role'          => 'edit_theme_options',
							'layout'                => 'fixed',
							'page_title'            => 'Translate Frontend',
							'menu_label'            => 'Translate Frontend',
							'priority'              => 54,
						)
					);
			}
		} else {
			if ( class_exists( '\JNews\Dashboard\Panel\Panel' ) ) {
				$dashboard_option = self::dashboard_option();
				$translation_slug = self::translation_slug();
				$option           = new \JNews\Dashboard\Panel\Panel(
					array(
						'type'                  => 'vafpress',
						'is_dev_mode'           => false,
						'option_key'            => 'jnews_translate',
						'page_slug'             => $translation_slug,
						'menu_page'             => 'jnews',
						'template'              => $dashboard_option,
						'use_auto_group_naming' => true,
						/**
						 * Validate
						 *
						 * @see \JNews\Util\ValidateLicense::is_license_validated
						 * @since 8.0.0
						 */
						'use_util_menu'         => function_exists( 'jnews_is_active' ) && jnews_is_active()->is_license_validated(),
						'minimum_role'          => 'edit_theme_options',
						'layout'                => 'fixed',
						'page_title'            => 'Translate Frontend',
						'menu_label'            => 'Translate Frontend',
						'priority'              => 54,
					)
				);
			}
		}
		if ( $return ) {
			return $option;
		}
	}

	/**
	 * Dashboard Option
	 *
	 * @return array
	 */
	public static function dashboard_option() {
		if ( is_admin() || wp_is_json_request() ) {
			remove_filter( 'jnews_admin_translate_option', 'JNews_Translation_Option::translation_option' );
			add_filter( 'jnews_admin_translate_option', 'JNews_Translation_Option::translation_option', 10 );
		}

		return array(
			'title'   => 'Frontend Translation',
			'logo'    => '',
			'version' => JNEWS_FRONT_TRANSLATION_VERSION,
			'menus'   => apply_filters( 'jnews_admin_translate_option', array() ),
			'layout'  => 'fixed',
		);
	}

	/**
	 * Translation Option
	 *
	 * @param array $option Option list.
	 *
	 * @return array
	 */
	public static function translation_option( $option ) {
		$translation_setting = include JNEWS_FRONT_TRANSLATION_DIR . 'options/translation-setting.php';
		$option              = self::merge_option( $option, $translation_setting );

		/**
		 * @see \JNews\Util\ValidateLicense::is_license_validated
		 * @since 8.0.0
		 */
		if ( function_exists( 'jnews_is_active' ) && jnews_is_active()->is_license_validated() ) {
			$translation = include JNEWS_FRONT_TRANSLATION_DIR . 'options/translation.php';
			$option      = self::merge_option( $option, $translation );
		}

		return $option;
	}

	/**
	 * Merge option
	 *
	 * @param array $option Option list.
	 * @param array $newoption New option list.
	 *
	 * @return array
	 */
	public static function merge_option( $option, $newoption ) {
		if ( empty( $option ) ) {
			return array( $newoption );
		} else {
			return array_merge( $option, array( $newoption ) );
		}
	}
}
