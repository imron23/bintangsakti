<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
class JNews_Gallery_Option {

	/**
	 * @var JNews_Gallery_Option
	 */
	private static $instance;

	/**
	 * @var Jeg\Customizer\Customizer
	 */
	private $customizer;

	/**
	 * @return JNews_Gallery_Option
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

		$preview_slider_section = array(
			'id'       => 'jnews_preview_slider_section',
			'title'    => esc_html__( 'Gallery Shortcode', 'jnews-gallery' ),
			'panel'    => 'jnews_image_panel',
			'priority' => 250,
			'type'     => 'jnews-lazy-section',
		);

		$preview_slider_ads_section = array(
			'id'       => 'jnews_preview_slider_ads_section',
			'title'    => esc_html__( 'Preview Slider Ads', 'jnews-gallery' ),
			'panel'    => 'jnews_ads',
			'priority' => 250,
			'type'     => 'jnews-lazy-section',
		);

		$this->customizer->add_section( $preview_slider_section );
		$this->customizer->add_section( $preview_slider_ads_section );
	}

}
