<?php
/**
 * Class jQuery_Migrate
 *
 */

namespace Jeg\Util;

use Jeg\Customizer\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

class Jquery_Migrate {

	private static $instance;

	private function __construct() {
		$this->setup_hook();
	}

	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

    public function setup_hook() {
		if ( apply_filters( 'jquery_migrate_panel', '' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'integrate_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'integrate_scripts' ), 1 );
			add_action( 'jeg_register_customizer_option', array( $this, 'register_lazy_section' ), 91 );
			add_filter( 'jeg_register_lazy_section', array( $this, 'load_customizer' ) );
		}
    }

	public static function integrate_scripts () {
		if ( jeg_get_option( 'jquery_option' ) ) {
			wp_enqueue_script( 'jquery-migrate', JEG_URL . '/assets/js/jquery-migrate/jquery-migrate.js', [ 'jquery' ], '1.4.1' );
		}
	}

    public function register_lazy_section() {
        $customizer = Customizer::get_instance();

        $customizer->add_section( array(
            'id'       => 'jeg_migrate_section',
            'title'    => esc_html__( 'jQuery Migrate', 'jeg' ),
            'panel'    => apply_filters( 'jquery_migrate_panel', '' ),
            'priority' => 1,
            'type'     => 'jeg-lazy-section',
        ) );
    }

    public function load_customizer( $result ) {
        $result['jeg_migrate_section'][] = JEG_CLASSPATH . '/customizer/migrate/option.php';

        return $result;
    }
}
