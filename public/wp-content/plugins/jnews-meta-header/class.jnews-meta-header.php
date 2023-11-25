<?php
/**
 * @author : Jegtheme
 */

class JNews_Meta_Header {

	/**
	 * @var JNews_Meta_Header
	 */
	private static $instance;

	/**
	 * @var JNews_Meta_Facebook
	 */
	private $facebook_meta;

	/**
	 * @var JNews_Meta_Twitter
	 */
	private $twitter_meta;

	/**
	 * @return JNews_Meta_Header
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	private function __construct() {
		add_action( 'wp', array( $this, 'instantiate_post' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'load_metabox' ) );
		add_action( 'wp_head', array( $this, 'generate_social_meta' ), 1 );
	}

	public function load_metabox() {
		if ( class_exists( 'VP_Metabox' ) ) {
			global $pagenow;
			if ( $pagenow === 'post.php' || $pagenow === 'post-new.php' || ! is_admin() ) {
				new VP_Metabox( JNEWS_META_HEADER_DIR . '/metabox/social-meta.php' );
			}
		}
	}

	public function instantiate_post() {
		require_once 'class.jnews-meta-abstract.php';
		require_once 'class.jnews-meta-facebook.php';
		require_once 'class.jnews-meta-twitter.php';

		$post_id = get_the_ID();

		$this->facebook_meta = new JNews_Meta_Facebook( $post_id );
		$this->twitter_meta  = new JNews_Meta_Twitter( $post_id );
	}

	public function generate_social_meta() {
		// see wPoGON7R
		if ( ! is_admin() && $this->facebook_meta instanceof JNews_Meta_Facebook && $this->twitter_meta instanceof JNews_Meta_Twitter ) {
			// Language is required for gettext.
			// Without it, 'gettext' or '_' will cause error instead of translate text.
			// phpcs:disable WordPress.PHP.DiscouragedPHPFunctions
			$locale      = function_exists( 'jnews_get_locale' ) ? jnews_get_locale() : get_locale();
			$prev_locale = getenv( 'LC_ALL' );
			putenv( 'LC_ALL=' . $locale );

			$this->facebook_meta->render_meta();
			$this->twitter_meta->render_meta();

			$this->add_fb_app_id();

			// Revert Language.
			if ( $prev_locale ) {
				putenv( 'LC_ALL=' . $prev_locale );
			} else {
				putenv( 'LC_ALL' );
			}
			// phpcs:enable WordPress.PHP.DiscouragedPHPFunctions
		}
	}

	public function add_fb_app_id() {
		$id = jnews_get_option( 'social_meta_fb_app_id', '' );

		if ( ! empty( $id ) ) {
			echo '<meta property="fb:app_id" content="' . $id . '">';
		}
	}
}
