<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_INSTAGRAM\API;

/**
 * Class Object_Api
 *
 * @package JNEWS_INSTAGRAM\API
 */
abstract class Object_Api {
	/**
	 * @var $userid
	 */
	protected $userid;

	/**
	 * @var $username
	 */
	protected $username;

	/**
	 * @var $access_token
	 */
	protected $access_token;

	/**
	 * @var $transient_id
	 */
	protected $transient_id;

	/**
	 * Get Instagram token option
	 *
	 * @param bool $key
	 *
	 * @return bool
	 */
	public function get( $key = false ) {
		$instagram_token = get_option( 'jnews_option[jnews_instagram]', array() );
		if ( empty( $instagram_token ) ) {
			return false;
		}
		if ( ! empty( $instagram_token[ $key ] ) ) {
			return $instagram_token[ $key ];
		}

		return false;
	}

	/**
	 * Update Instagram token option
	 *
	 * @param bool $key
	 * @param bool $value
	 */
	public function update( $key = false, $value = false ) {

		if ( empty( $key ) || empty( $value ) ) {
			return;
		}

		$account = get_option( 'jnews_option[jnews_instagram]', array() );

		$account[ $key ] = $value;

		update_option( 'jnews_option[jnews_instagram]', $account );
	}

	/**
	 * Check if smash ballon plugin active
	 *
	 * @return bool
	 */
	public function is_sb_activate() {
		return function_exists( 'sb_instagram_feed_init' );
	}

	/**
	 * Clean Access TokenClean Access Token
	 *
	 * @param $maybe_dirty
	 *
	 * @return string|string[]
	 */
	protected function clean( $maybe_dirty ) {

		if ( substr_count( $maybe_dirty, '.' ) < 3 ) {
			return str_replace( '634hgdf83hjdj2', '', $maybe_dirty );
		}

		$parts     = explode( '.', trim( $maybe_dirty ) );
		$last_part = $parts[2] . $parts[3];
		$cleaned   = $parts[0] . '.' . base64_decode( $parts[1] ) . '.' . base64_decode( $last_part );

		return $cleaned;
	}

	/**
	 * Check if there is a connected account
	 *
	 * @return bool
	 */
	public function is_active() {

		$is_active = false;

		if ( $this->userid && $this->access_token ) {
			$is_active = true;
		}

		return $is_active;
	}

	/**
	 * Check if the Access token is expired
	 *
	 * @return bool
	 */
	public function is_expired() {

		if ( ! $this->is_active() ) {
			return false;
		}

		$expires_on = $this->get( 'expires_on' );

		return empty( $expires_on ) || ( ! empty( $expires_on ) && $expires_on < time() );
	}

	/**
	 * Make the connection to Instagram
	 *
	 * @param bool $url
	 *
	 * @return bool|mixed|string|WP_Error
	 */
	protected function remote_get( $url = false ) {

		$args = array(
			'timeout'    => 30,
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36',
		);

		$request = wp_remote_get( $url, $args );

		return $this->check_for_errors( $request );
	}

	/**
	 * Check if the reply has error
	 *
	 * @param bool $response
	 *
	 * @return bool|mixed|string|WP_Error
	 */
	protected function check_for_errors( $response = false ) {

		// Check Response for errors
		$response_code    = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

		if ( is_wp_error( $response ) ) {
			return new \WP_Error( 'http_error', $response->get_error_message() );
		}

		if ( ! empty( $response->errors ) && isset( $response->errors['http_request_failed'] ) ) {
			return new \WP_Error( 'http_error', esc_html( current( $response->errors['http_request_failed'] ) ) );
		}

		if ( 200 !== $response_code ) {

			// Get value of Error - contains more details
			$response = wp_remote_retrieve_body( $response );
			$response = json_decode( $response, true );

			if ( ! empty( $response['error']['message'] ) ) {
				return new \WP_Error( $response_code, $response['error']['message'] );
			}

			if ( empty( $response_message ) ) {
				return new \WP_Error( $response_code, 'Connection Error' );
			} else {
				return new \WP_Error( $response_code, $response_message );
			}
		}

		return $response;
	}

	/**
	 * Get the Error Messages
	 *
	 * @param bool $error_id
	 *
	 * @return string
	 */
	public function get_error( $error_id = false ) {

		if ( ! empty( $error_id ) ) {

			switch ( $error_id ) {
				case 'inactive':
					return esc_html__( 'Go to the Customizer > JNews : Social, Like & View > Instagram Feed Setting, to connect your Instagram account.', 'jnews-instagram' );
					break;

				case 'expired':
					return esc_html__( 'The Instagram Access Token is expired, Go to the Customizer > JNews : Social, Like & View > Instagram Feed Setting, to refresh it.', 'jnews-instagram' );
					break;
			}
		}
	}
}
