<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_INSTAGRAM;

use JNEWS_INSTAGRAM\API\Instagram_Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Instagram
 *
 * @package JNEWS_INSTAGRAM
 */
class Instagram {
	/**
	 * @var integer
	 */
	private $row;
	private $column;
	private $count;

	/**
	 * @var string
	 */
	private $cache_key = JNEWS_INSTAGRAM_FEED_CACHE;
	private $username;
	private $content;
	private $sort;
	private $hover;
	private $newtab;
	private $follow;
	private $token;

	/**
	 * @var string
	 */
	private $user_id;

	/**
	 * Instagram constructor.
	 *
	 * @param $param
	 * @param int   $row
	 */
	public function __construct( $param, $row = 1 ) {
		$this->row    = isset( $param['row']['size'] ) ? $param['row']['size'] : $param['row'];
		$this->column = isset( $param['column']['size'] ) ? $param['column']['size'] : $param['column'];
		$this->video  = $param['video'];
		$this->sort   = $param['sort'];
		$this->hover  = $param['hover'];
		$this->newtab = $param['newtab'];
		$this->follow = $param['follow'];
		$this->token  = isset( $param['token'] ) ? $param['token'] : '';
		$this->count  = $this->row * $this->column;
	}

	/**
	 * @param $data
	 */
	public function render_content( $data ) {
		$content = '';
		if ( ! empty( $data ) && is_array( $data ) ) {
			$data    = array_slice( $data, 0, $this->row * $this->column ); //see (#7rxYcmJt)
			switch ( $this->sort ) {
				case 'most_recent':
					usort(
						$data,
						function ( $a, $b ) {
							return strtotime( $b['timestamp'] ) - strtotime( $a['timestamp'] );
						}
					);
					break;
				case 'least_recent':
					usort(
						$data,
						function ( $a, $b ) {
							return strtotime( $a['timestamp'] ) - strtotime( $b['timestamp'] );
						}
					);
					break;
			}

			$a = 1;
			foreach ( $data as $media ) {
				if ( $a % $this->column == 0 ) {
					$class = 'last';
				} elseif ( $a % $this->column == 1 ) {
					$class = 'first';
				} else {
					$class = '';
				}

				$media_caption = isset( $media['caption'] ) ? $media['caption'] : '';

				switch ( $media['media_type'] ) {
					case 'IMAGE':
					case 'CAROUSEL_ALBUM':
						$media_tag = apply_filters( 'jnews_single_image', $media['media_url'], $media_caption, '1000' );
						break;
					case 'VIDEO':
						switch ( $this->video ) {
							case 'video':
								$media_tag = apply_filters( 'jnews_instagram_video', $media['media_url'], $media_caption );
								break;
							case 'thumbnail':
								$media_tag = apply_filters( 'jnews_single_image', $media['thumbnail_url'], $media_caption, '1000' );
								break;
						}
						break;
				}

				$content .=
					"<li class='{$class}'>
						<a href='{$media['permalink'] }' {$this->newtab}>
							{$media_tag}
						</a>
					</li>";

				if ( $a >= ( $this->row * $this->column ) ) {
					break;
				}

				$a ++;
			}
		}
		$this->content = $content;
	}

	/**
	 * Follow button
	 *
	 * @param $follow_button_option
	 *
	 * @return string
	 */
	public function follow_button( $follow_button_option ) {
		$follow_button = '';
		if ( $follow_button_option ) {
			$follow_button =
				"<h3 class='jeg_instagram_heading'>
                    <a href='//www.instagram.com/{$this->username}' {$this->newtab}>
                        <i class='fa fa-instagram'></i>
                        " . esc_html( $follow_button_option ) . '
                    </a>
                </h3>';
		}

		return $follow_button;
	}

	/**
	 *
	 */
	public function generate_content() {
		$instagram = Instagram_Api::get_instance();
		if ( ! $instagram->is_active() || $instagram->is_expired() ) {
			$response = '';
			if ( $instagram->is_expired() ) {
				$response = $instagram->get_error( 'expired' );
			}
			if ( ! $instagram->is_active() ) {
				$response = $instagram->get_error( 'inactive' );
			}
			$this->content = "<div class=\"alert alert-error alert-compatibility\" style=\"position: relative; opacity: 1; visibility: visible;\">{$response}</div>";
		} else {
			$this->username = $instagram->get( 'username' );
			$this->render_content( $instagram->get_data() ); 
		}

		return $this->content;
	}

	/**
	 * Generate element for Instagram feed
	 *
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function generate_element( $echo = true ) {
		if ( ! wp_script_is( 'jnews-instagram' ) ) {
			wp_enqueue_script( 'jnews-instagram' );
		}
		$follow_button = $this->follow_button( $this->follow );

		$this->generate_content();

		$output = "<div class='jeg_instagram_feed clearfix'>
                        {$follow_button}
                        <ul class='instagram-pics instagram-size-large col{$this->column} {$this->hover}'>{$this->content}</ul>
                    </div>";

		if ( $echo ) {
			echo jnews_sanitize_output( $output );
		}

		return $output;
	}
}
