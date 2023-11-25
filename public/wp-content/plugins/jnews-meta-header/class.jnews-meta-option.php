<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
class JNews_Social_Meta_Option {

	/**
	 * @var JNews_Social_Meta_Option
	 */
	private static $instance;

	/**
	 * @var Jeg\Customizer\Customizer
	 */
	private $customizer;

	/**
	 * @return JNews_Social_Meta_Option
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
		$social_meta_section = array(
			'id'       => 'jnews_social_meta_section',
			'title'    => esc_html__( 'Social Meta Setting', 'jnews-meta-header' ),
			'panel'    => 'jnews_social_panel',
			'priority' => 252,
			'type'     => 'jnews-lazy-section',
		);

		$this->customizer->add_section( $social_meta_section );
	}
}
