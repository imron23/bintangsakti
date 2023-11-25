<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_INSTAGRAM\Customizer;

/**
 * Class Customizer
 *
 * @package JNEWS_INSTAGRAM\Customizer
 */
class Customizer {

	/**
	 * Instance of Customizer
	 *
	 * @var Customizer
	 */
	private static $instance;

	/**
	 * @var \Jeg\Customizer\Customizer
	 */
	private $customizer;

	/**
	 * Customizer constructor.
	 */
	private function __construct() {
		add_action( 'jeg_register_customizer_option', array( $this, 'customizer_option' ) );
		add_filter( 'jeg_register_lazy_section', array( $this, 'jnews_instagram_lazy_section' ) );
	}

	/**
	 * Singleton page for Customizer class
	 *
	 * @return Customizer
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Register new customizer option
	 */
	public function customizer_option() {
		if ( class_exists( '\Jeg\Customizer\Customizer' ) ) {
			$this->customizer = \Jeg\Customizer\Customizer::get_instance();

			$this->set_section();
		}
	}

	/**
	 * Set new section panel
	 */
	public function set_section() {
		$instagram_feed_section = array(
			'id'       => 'jnews_instagram_feed_section',
			'title'    => esc_html__( 'Instagram Feed Setting', 'jnews-instagram' ),
			'panel'    => 'jnews_social_panel',
			'priority' => 252,
			'type'     => 'jnews-lazy-section',
		);

		$this->customizer->add_section( $instagram_feed_section );
	}

	/**
	 * Register new section and their respective file
	 *
	 * @param $result
	 *
	 * @return mixed
	 */
	public function jnews_instagram_lazy_section( $result ) {
		$result['jnews_instagram_feed_section'][] = JNEWS_INSTAGRAM_DIR . 'class/customizer/sections/instagram-option.php';

		return $result;
	}
}
