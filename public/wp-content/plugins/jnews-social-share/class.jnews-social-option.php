<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Theme JNews Option
 */
class JNews_Social_Option {

	/**
	 * @var JNews_Social_Option
	 */
	private static $instance;

	/**
	 * @var Jeg\Customizer\Customizer
	 */
	private $customizer;

	/**
	 * @return JNews_Social_Option
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	private function __construct() {
		if ( class_exists( 'Jeg\Customizer\Customizer' ) ) {
			$this->customizer = Jeg\Customizer\Customizer::get_instance();

			$this->set_section();
		}
	}

	public function set_section() {
		$social_like_section = array(
			'id'       => 'jnews_social_like_section',
			'title'    => esc_html__( 'Social Bar, View & Like', 'jnews-social-share' ),
			'panel'    => 'jnews_social_panel',
			'priority' => 176,
			'type'     => 'jnews-lazy-section',
		);

		$select_share_section = array(
			'id'       => 'jnews_select_share_section',
			'title'    => esc_html__( 'Social Select & Share', 'jnews-select-share' ),
			'panel'    => 'jnews_social_panel',
			'priority' => 177,
			'type'     => 'jnews-lazy-section',
		);

		$this->customizer->add_section( $social_like_section );
		$this->customizer->add_section( $select_share_section );
	}
}
