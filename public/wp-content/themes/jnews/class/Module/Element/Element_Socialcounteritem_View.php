<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleViewAbstract;
use Abraham\TwitterOAuth\TwitterOAuth;

Class Element_Socialcounteritem_View extends ModuleViewAbstract
{
	private $output = '';

	private $data_cache;

	private $cache_key = "jnews_social_counter_widget_cache";

	public function render_module($attr, $column_class)
    {
		/** For debugging */
		// delete_option( $this->cache_key );

	    $this->data_cache = get_option( $this->cache_key, array() );

		$this->output = ''; // Bug Fix Duplicate Social Counter Issue See : EWRnku7q

	    $this->init_social( $attr );

	    return $this->output;
    }

	protected function init_social( $attr )
	{
		if ( ! empty( $attr['social_url'] ) )
		{
			$this->service_social( $attr );
		}
	}

	protected function service_social( $data )
	{
		switch ( $data['social_icon'] )
		{
			case 'facebook':
				global $social_fb_key;
				$social_id = wp_parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );
				if ( ! empty( $social_id ) && ! empty( $social_fb_key ) ) {
					$array = array(
						'social_type' => 'facebook',
						'social_id'   => $social_id,
						'social_text' => jnews_return_translation( 'Fan', 'jnews', 'fan' ),
						'social_url'  => $data['social_url'],
						'social_grab' => 'https://graph.facebook.com/v11.0/' . $social_id . '?access_token=' . apply_filters( 'jnews_facebook_token_access', $social_fb_key ) . '&fields=followers_count',
					);
					$this->check_cache( $array );
				}
				break;

			case 'twitter':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'twitter',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => $data['social_url'],
					);
					$this->check_cache($array);
				}
				break;

			case 'instagram':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );
				$social_id = str_replace( '/', '', $social_id );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'instagram',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://www.instagram.com/'. $social_id .'/?__a=1',
					);
					$this->check_cache($array);
				}
				break;

			case 'pinterest':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'pinterest',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => $data['social_url'],
					);
					$this->check_cache($array);
				}
				break;

			case 'vimeo':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'vimeo',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://vimeo.com/' . $social_id . '/following/followers/',
					);
					$this->check_cache($array);
				}
				break;

			case 'soundcloud':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'soundcloud',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => $data['social_url'],
					);
					$this->check_cache($array);
				}
				break;

			case 'behance':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				global $social_bh_key;

				if ( !empty($social_id) && !empty($social_bh_key) )
				{
					$array = array(
						'social_type'    => 'behance',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://api.behance.net/v2/users/' . $social_id . '?client_id=' . apply_filters( 'jnews_behance_token_access', $social_bh_key ),
					);
					$this->check_cache($array);
				}
				break;

			case 'flickr':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );
				$social_id = str_replace( 'photos/', '', $social_id );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'flickr',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => $data['social_url'],
					);
					$this->check_cache($array);
				}
				break;

			case 'twitch':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'twitch',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
					);
					$this->check_cache($array);
				}
				break;

			case 'vk':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				global $social_vk_id, $social_vk_token;

				if ( !empty($social_id) )
				{
					$array = array(
						'social_type'    => 'vk',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://api.vk.com/method/users.getFollowers?user_id=' . $social_vk_id . '&v=5.74&access_token=' . $social_vk_token,
					);
					$this->check_cache($array);
				}
				break;

			case 'youtube':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				global $social_gg_key;

				if ( !empty($social_id) && !empty($social_gg_key) )
				{
					$array = array(
						'social_type'    => 'youtube',
						'social_text'    => jnews_return_translation('Subscriber', 'jnews', 'subscriber'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://www.googleapis.com/youtube/v3/channels?part=statistics&key=' . apply_filters( 'jnews_youtube_token_access', $social_gg_key ),
					);

					$social_id = explode("/", $social_id);

					if ( is_array($social_id) )
					{
						if ( $social_id[0] == 'channel' )
						{
							$array['social_grab'] .= '&id=' . $social_id[1];
						} else {
							$array['social_grab'] .= '&forUsername=' . $social_id[1];
						}

						$array['social_id'] = $social_id[1];
					}

					$this->check_cache($array);
				}
				break;

			case 'rss':
				global $social_rss_count;

				if ( is_numeric($social_rss_count) )
				{
					$array = array(
						'social_text'    => jnews_return_translation('Subscriber', 'jnews', 'subscriber'),
						'social_url'     => empty( $data['social_url'] ) ? esc_url( jnews_home_url_multilang( '/feed' ) ) : $data['social_url'],
						'social_data'    => $social_rss_count,
						'social_type'    => 'rss',
					);

					$this->build_content($array);
				}
				break;

			case 'tiktok':
				$social_id = parse_url( $data['social_url'] );
				$social_id = trim( $social_id['path'], '/' );

				if ( ! empty( $social_id ) )
				{
					$array = array(
						'social_type'    => 'tiktok',
						'social_id'      => $social_id,
						'social_text'    => jnews_return_translation('Follower', 'jnews', 'follower'),
						'social_url'     => $data['social_url'],
						'social_grab'    => 'https://www.tiktok.com/node/share/user/' . $social_id,
					);
					$this->check_cache($array);
				}
				break;
		}
	}

	protected function build_content($data)
	{
		global $social_new_tab;

		$count = jnews_number_format($data['social_data']);

		if ( $count > 1 ) {
			switch ( $data['social_type'] ) {
				case 'facebook':
					$data['social_text'] = jnews_return_translation( 'Fans', 'jnews', 'fans' );
					break;
				case 'twitter':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'instagram':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'pinterest':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'vimeo':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'soundcloud':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'behance':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'flickr':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'twitch':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'vk':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
				case 'youtube':
					$data['social_text'] = jnews_return_translation( 'Subscribers', 'jnews', 'subscribers' );
					break;
				case 'rss':
					$data['social_text'] = jnews_return_translation( 'Subscribers', 'jnews', 'subscribers' );
					break;
				case 'tiktok':
					$data['social_text'] = jnews_return_translation( 'Followers', 'jnews', 'followers' );
					break;
			}
		}
		
		$this->output =
			"<li class=\"jeg_{$data['social_type']}\">
                <a href=\"{$data['social_url']}\" {$social_new_tab}><i class=\"fa fa-{$data['social_type']}\"></i>
                    <span>{$count}</span>
                    <small>{$data['social_text']}</small>
                </a>
            </li>";
	}

	protected function check_cache( $data )
	{
		$now          = current_time('timestamp');
		$add_cache    = true;
		$cache_expire = apply_filters( 'jnews_social_counter_widget_expired', 60 * 60 * 24 );
		$data_count = $update_cache = null;

		if ( !empty($this->data_cache) && is_array($this->data_cache) )
		{
			foreach ($this->data_cache as &$social_data)
			{
				if ( $data['social_type'] == $social_data['social_type'] && $data['social_id'] == $social_data['social_id'] )
				{
					$add_cache = false;

					if ( $social_data['social_expire'] < ( $now - $cache_expire ) )
					{
						$count = $this->fetch_data( $data );

						if ( ! empty( $count ) )
						{
							$social_data['social_expire'] = current_time('timestamp');
							$social_data['social_data']   = $count;
							$update_cache = true;
						}
					}

					$data_count = $social_data['social_data'];
				}
			}
		}

		if ( $add_cache )
		{
			$data_count = $this->fetch_data( $data );

			if ( ! empty( $data_count ) )
			{
				$this->data_cache[] = array(
					'social_type'   => $data['social_type'],
					'social_id'     => $data['social_id'],
					'social_expire' => current_time('timestamp'),
					'social_data'   => $data_count,
				);
			} else {
				$add_cache = false;
			}
		}

		if ( $add_cache || $update_cache ) update_option( $this->cache_key, $this->data_cache );

		// call build content
		if ( !empty( $data_count ) )
		{
			$data['social_data'] = $data_count;
			$this->build_content( $data );
		}
	}

	protected function fetch_data( $data )
	{
		if ( $data['social_type'] === 'twitter' )
		{
			return $this->get_twitter_counter($data['social_id']);
		}

		if ( $data['social_type'] === 'instagram' ) {
			$response = jnews_get_instagram_data( $data['social_id'], 'user' );
		} else {
			$response = wp_remote_get($data['social_grab'], array(
				'timeout' => 10,
			));
		}

		if ( ! is_wp_error( $response ) && isset( $response['response'] ) && isset( $response['response']['code'] ) && $response['response']['code'] == '200' )
		{
			switch ( $data['social_type'] )
			{
				case 'twitter':
					$pattern = "/<div class=\"statnum\">(.*?)<\/div>/";
					preg_match_all($pattern, $response['body'], $matches);

					if ( !empty($matches[1][2]) )
					{
						$result = '';
						foreach (str_split($matches[1][2]) as $char) {
							if (is_numeric($char))
							{
								$result .= $char;
							}
						}
						return (int) $result;
					}
					break;

				case 'instagram':
					if ( ! empty( $response['counts']['followed_by'] ) ) {
						return $response['counts']['followed_by'];
					}
					break;

				case 'pinterest':
					$pattern = "/name=\"pinterestapp:followers\" content=\"(.*?)\"/";
					preg_match($pattern, $response['body'], $matches);

					if ( !empty($matches[1]) )
					{
						return (int) $matches[1];
					}
					break;

				case 'vimeo':
					$pattern = "/data-title=\"(.*?) Follower(s?)\"/";
					preg_match($pattern, $response['body'], $matches);

					if ( !empty($matches[1]) )
					{
						$result = '';
						foreach (str_split($matches[1]) as $char) {
							if (is_numeric($char))
							{
								$result .= $char;
							}
						}
						return (int) $result;
					}
					break;

				case 'soundcloud':
					$pattern = "/<meta property=\"soundcloud:follower_count\" content=\"(.*?)\">/";
					preg_match($pattern, $response['body'], $matches);

					if ( !empty($matches[1]) )
					{
						return (int) $matches[1];
					}
					break;

				case 'youtube':
					$result = json_decode( $response['body'] );
					if ( !empty($result->items[0]) )
					{
						if ( !$result->items[0]->statistics->hiddenSubscriberCount ) 
						{
							return (int) $result->items[0]->statistics->subscriberCount;
						}
					}
					break;

				case 'facebook':
					$result = json_decode( $response['body'] );
					if ( !empty($result->fan_count) )
					{
						return (int) $result->fan_count;
					}
					break;

				case 'behance':
					$result = json_decode( $response['body'] );
					if ( !empty($result->user->stats->followers) )
					{
						return (int) $result->user->stats->followers;
					}
					break;

				case 'flickr':
					$pattern = "/\"followerCount\":(.*?),\"/";
					preg_match($pattern, $response['body'], $matches);

					if ( !empty($matches[1]) )
					{
						return (int) $matches[1];
					}
					break;

				case 'twitch':
					$result = json_decode( $response['body'] );
					if ( !empty($result->followers) )
					{
						return $result->followers;
					}
					break;

				case 'vk':
					$result = json_decode( $response['body'] );
					if ( !empty($result->response->count) )
					{
						return $result->response->count;
					}
					break;

				case 'tiktok':
					$result = json_decode( $response['body'] );
					if ( !empty($result->body->userData->fans) )
					{
						return $result->body->userData->fans;
					}
					break;
			}
		}
		return null;
	}

	protected function get_twitter_counter($id)
	{
		$counter = 0;

		global $tw_consumer_key, $tw_consumer_secret, $tw_access_token, $tw_access_token_secret;

		if ( ! empty( $tw_consumer_key ) && ! empty( $tw_consumer_secret ) && ! empty( $tw_access_token ) && ! empty( $tw_access_token_secret ) ) {
			if ( class_exists( 'Abraham\TwitterOAuth\TwitterOAuth' ) ) {
				$twitter  = new TwitterOAuth($tw_consumer_key, $tw_consumer_secret, $tw_access_token, $tw_access_token_secret);
				$userinfo = $twitter->get('users/lookup',array('screen_name' => $id));

				if ( empty( $userinfo ) || $userinfo->errors ) return $counter;

				if ( $userinfo[0]->followers_count )
				{
					$counter = (int) $userinfo[0]->followers_count;
				}
			}
		}

		return $counter;
	}
}
