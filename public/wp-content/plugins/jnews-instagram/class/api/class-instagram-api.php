<?php

namespace JNEWS_INSTAGRAM\API;

class Instagram_Api extends Object_Api {
	/**
	 * Instance of Instagram_Api
	 *
	 * @var Instagram_Api
	 */
	private static $instance;

	/**
	 * Singleton page of Instagram_Api class
	 *
	 * @return Instagram_Api
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Setup Hook
	 */
	private function setup_hook() {
		$this->userid       = $this->get( 'id' );
		$this->username     = $this->get( 'username' );
		$this->access_token = $this->get( 'access_token' );
		$this->transient_id = JNEWS_INSTAGRAM_FEED_CACHE . '_' . $this->userid;
		add_action( 'init', array( $this, 'jnews_instagram_page' ) );
		add_action( 'admin_init', array( $this, 'refresh_access_token' ) );
	}


	/**
	 * Override smash ballon page
	 */
	public function jnews_instagram_page() {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) || $this->is_sb_activate() ) {
			return;
		}

		if ( ! empty( $_GET['page'] ) && sanitize_text_field( $_GET['page'] ) === 'sb-instagram-feed' ) {

			if ( ! empty( $_GET['access_token'] ) ) {

				$account = array(
					'id'           => sanitize_text_field( $_GET['id'] ),
					'username'     => sanitize_text_field( $_GET['username'] ),
					'access_token' => $this->clean( sanitize_text_field( $_GET['access_token'] ) ),
					'expires_on'   => (int) $_GET['expires_in'] + time(),
				);
				update_option( 'jnews_option[jnews_instagram]', $account );
			}

			// Redirect
			$redirect = admin_url( 'customize.php?autofocus[section]=jnews_instagram_feed_section' );
			wp_redirect( $redirect );

			exit;
		}
	}

	/**
	 * Make the connection to Instagram
	 */
	public function get_data( $purge = false ) {

		if ( ! $this->is_active() ) {
			return false;
		}

		if ( get_transient( $this->transient_id ) !== false && ! $purge ) {
			return get_transient( $this->transient_id );
		}

		$this->refresh_access_token();

		$args = array(
			'fields'       => 'media_url,thumbnail_url,caption,id,media_type,timestamp,username,permalink', //see (#7rxYcmJt)
			'limit'        => 50,
			'access_token' => $this->access_token,
		);

		$url = add_query_arg( $args, "https://graph.instagram.com/$this->userid/media" );

		$request = $this->remote_get( $url );

		if ( is_wp_error( $request ) ) {
			return $request;
		}

		$media = wp_remote_retrieve_body( $request );
		$media = json_decode( $media, true );

		$expiration = 24 * HOUR_IN_SECONDS;

		set_transient( $this->transient_id, $media['data'], $expiration );

		return $media['data'];
	}

	/**
	 * Check if need to refresh the Access Token.
	 *
	 * @return bool
	 */
	private function time_passed_threshold() {

		$expiration_time   = $this->get( 'expires_on' );
		$refresh_threshold = $expiration_time - ( 30 * DAY_IN_SECONDS );

		return $refresh_threshold < time();
	}

	/**
	 * Refresh access token if needed.
	 * Valid for 60 days and refresh every 30 days
	 *
	 * @return bool|mixed|string|void|\WP_Error
	 */
	public function refresh_access_token() {

		if ( ! $this->is_active() ) {
			return false;
		}

		if ( ! $this->time_passed_threshold() ) {
			return;
		}

		$url = add_query_arg(
			array(
				'grant_type'   => 'ig_refresh_token',
				'access_token' => $this->access_token,
			),
			'https://graph.instagram.com/refresh_access_token'
		);

		$request = $this->remote_get( $url );

		if ( is_wp_error( $request ) ) {
			return $request;
		}

		$data = wp_remote_retrieve_body( $request );
		$data = json_decode( $data, true );

		if ( ! empty( $data['access_token'] ) ) {
			$access_token = $this->clean( sanitize_text_field( $data['access_token'] ) );
			$expires_on   = (int) $data['expires_in'] + time();

			$this->update( 'access_token', $access_token );
			$this->update( 'expires_on', $expires_on );
		}
	}

	/**
	 * JNews_Instagram_Helper constructor.
	 */
	private function __construct() {
		$this->setup_hook();
	}
}
