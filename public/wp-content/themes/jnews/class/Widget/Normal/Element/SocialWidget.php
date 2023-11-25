<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Widget\Normal\Element;

use JNews\Widget\Normal\NormalWidgetInterface;

class SocialWidget implements NormalWidgetInterface {
	public function get_options() {
		return array(
			'title'          => array(
				'title' => esc_html__( 'Title', 'jnews' ),
				'desc'  => esc_html__( 'Title on widget header.', 'jnews' ),
				'type'  => 'text',
			),
			'widgetstyle'    => array(
				'title'   => esc_html__( 'Widget Style', 'jnews' ),
				'desc'    => esc_html__( 'Choose your widget style.', 'jnews' ),
				'type'    => 'select',
				'default' => 'nobg',
				'options' => array(
					'square'  => esc_html__( 'Square', 'jnews' ),
					'rounded' => esc_html__( 'Rounded', 'jnews' ),
					'circle'  => esc_html__( 'Circle', 'jnews' ),
					'nobg'    => esc_html__( 'No background', 'jnews' ),
				),
			),
			'icon_color'     => array(
				'title'   => esc_html__( 'Icon Color', 'jnews' ),
				'desc'    => esc_html__( 'Set global social icon color. Ignore it to use default icon color.', 'jnews' ),
				'type'    => 'color',
				'default' => '',
			),
			'bg_color'       => array(
				'title'   => esc_html__( 'Background Color', 'jnews' ),
				'desc'    => esc_html__( 'Set global social icon background color. Ignore it to use default background color.', 'jnews' ),
				'type'    => 'color',
				'default' => '',
			),
			'verticalsocial' => array(
				'title' => esc_html__( 'Enable Vertical Social', 'jnews' ),
				'desc'  => esc_html__( 'Align social icon vertical.', 'jnews' ),
				'type'  => 'checkbox',
			),
			'align'          => array(
				'title'   => esc_html__( 'Centered Content', 'jnews' ),
				'desc'    => wp_kses( __( 'This option only works if <strong>Enable Vertical Social</strong> option is unchecked.', 'jnews' ), wp_kses_allowed_html() ),
				'type'    => 'checkbox',
				'default' => false,
			),
			'beforesocial'   => array(
				'title' => esc_html__( 'Before social text', 'jnews' ),
				'desc'  => esc_html__( 'Allowed tag : a, b, strong, em.', 'jnews' ),
				'type'  => 'textarea',
			),
			'aftersocial'    => array(
				'title' => esc_html__( 'After social text', 'jnews' ),
				'desc'  => esc_html__( 'Allowed tag : a, b, strong, em.', 'jnews' ),
				'type'  => 'textarea',
			),
			'account'        => array(
				'title'     => esc_html__( 'Social Icon', 'jnews' ),
				'desc'      => esc_html__( 'Add icon for each of your social account.', 'jnews' ),
				'type'      => 'repeater',
				'choices'   => array(
					'limit' => '',
				),
				'default'   => array(
					array(
						'social_icon' => 'facebook',
						'social_url'  => 'https://www.facebook.com/jegtheme/',
					),
					array(
						'social_icon' => 'twitter',
						'social_url'  => 'https://twitter.com/jegtheme',
					),
				),
				'row_label' => array(
					'type'  => 'text',
					'value' => esc_attr__( 'Social Icon', 'jnews' ),
					'field' => false,
				),
				'fields'    => array(
					'social_icon' => array(
						'type'        => 'select',
						'label'       => esc_attr__( 'Social Icon', 'jnews' ),
						'description' => esc_attr__( 'Choose your social account.', 'jnews' ),
						'default'     => '',
						'id'          => 'social_icon',
						'choices'     => array(
							''              => esc_attr__( 'Choose Icon', 'jnews' ),
							'facebook'      => esc_attr__( 'Facebook', 'jnews' ),
							'twitter'       => esc_attr__( 'Twitter', 'jnews' ),
							'linkedin'      => esc_attr__( 'Linkedin', 'jnews' ),
							'pinterest'     => esc_attr__( 'Pinterest', 'jnews' ),
							'behance'       => esc_attr__( 'Behance', 'jnews' ),
							'github'        => esc_attr__( 'Github', 'jnews' ),
							'flickr'        => esc_attr__( 'Flickr', 'jnews' ),
							'tumblr'        => esc_attr__( 'Tumblr', 'jnews' ),
							'telegram'      => esc_attr__( 'Telegram', 'jnews' ),
							'dribbble'      => esc_attr__( 'Dribbble', 'jnews' ),
							'stumbleupon'   => esc_attr__( 'Stumbleupon', 'jnews' ),
							'soundcloud'    => esc_attr__( 'Soundcloud', 'jnews' ),
							'instagram'     => esc_attr__( 'Instagram', 'jnews' ),
							'vimeo'         => esc_attr__( 'Vimeo', 'jnews' ),
							'youtube'       => esc_attr__( 'Youtube', 'jnews' ),
							'twitch'        => esc_attr__( 'Twitch', 'jnews' ),
							'vk'            => esc_attr__( 'Vk', 'jnews' ),
							'reddit'        => esc_attr__( 'Reddit', 'jnews' ),
							'weibo'         => esc_attr__( 'Weibo', 'jnews' ),
							'rss'           => esc_attr__( 'RSS', 'jnews' ),
							'line'          => esc_attr__( 'Line', 'jnews' ),
							'discord'       => esc_attr__( 'Discord', 'jnews' ),
							'odnoklassniki' => esc_attr__( 'Odnoklassniki', 'jnews' ),
							'tiktok'        => esc_attr__( 'TikTok', 'jnews' ), // see jVWSazUJ
						),
					),
					'social_url'  => array(
						'type'        => 'text',
						'label'       => esc_attr__( 'Social URL', 'jnews' ),
						'description' => esc_attr__( 'Insert your social account url.', 'jnews' ),
						'default'     => '',
						'id'          => 'social_url',
					),
				),
			),
		);
	}


	public function render_widget( $instance, $text_content = null ) {
		extract( $instance );

		/**
		 * @var $title
		 * @var $widgetstyle
		 * @var $icon_color
		 * @var $bg_color
		 * @var $verticalsocial
		 * @var $align
		 * @var $beforesocial
		 * @var $aftersocial
		 * @var $account
		 * @var $widget_id
		 */
		$widgetstyle = isset( $widgetstyle ) ? $widgetstyle : '';
		$output      = '';

		$bg_color    = ( $widgetstyle != 'nobg' ) && ! empty( $bg_color ) ? 'background-color:' . $bg_color . ';' : '';
		$fill        = ! empty( $icon_color ) ? '#' . $widget_id . ' .socials_widget .jeg-icon svg { fill:' . $icon_color . '; }' : '';
		$svg_bg      = ( $widgetstyle != 'nobg' ) && ! empty( $bg_color ) ? '#' . $widget_id . ' .jeg_social_wrap .socials_widget a span.jeg-icon{' . $bg_color . '}' : '';
		$footer_fill = ! empty( $icon_color ) ? '#' . $widget_id . ' .jeg_social_wrap .socials_widget i span svg { fill:' . $icon_color . '; }' : '';
		$icon_color  = ! empty( $icon_color ) ? 'color:' . $icon_color . ';' : '';
		$inline_css  = ! empty( $bg_color ) || ! empty( $icon_color ) ? '#' . $widget_id . ' .jeg_social_wrap .socials_widget i{' . $bg_color . $icon_color . '}.jeg_social_wrap .socials_widget span {' . $bg_color . '}' . $svg_bg . $fill . $footer_fill : '';
		if ( isset( $account ) && ! empty( $account ) ) {
			$account = json_decode( urldecode( $account ) );
			if ( is_array( $account ) ) {
				foreach ( $account as $social ) {
					if ( ! empty( $social->social_url ) ) {
						switch ( $social->social_icon ) {
							case 'facebook':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Facebook', 'jnews', 'facebook' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_facebook">
                                            <i class="fa fa-facebook"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'linkedin':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'LinkedIn', 'jnews', 'linkedin' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_linkedin">
                                            <i class="fa fa-linkedin"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'pinterest':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Pinterest', 'jnews', 'pinterest' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_pinterest">
                                            <i class="fa fa-pinterest"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'behance':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Behance', 'jnews', 'behance' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_behance">
                                            <i class="fa fa-behance"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'github':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Github', 'jnews', 'github' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_github">
                                            <i class="fa fa-github"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'flickr':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Flickr', 'jnews', 'flickr' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_flickr">
                                            <i class="fa fa-flickr"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'tumblr':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Tumblr', 'jnews', 'tumblr' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_tumblr">
                                            <i class="fa fa-tumblr"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'dribbble':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Dribbble', 'jnews', 'dribbble' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_dribbble">
                                            <i class="fa fa-dribbble"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'soundcloud':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Soundcloud', 'jnews', 'soundcloud' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_soundcloud">
                                            <i class="fa fa-soundcloud"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'instagram':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Instagram', 'jnews', 'instagram' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_instagram">
                                            <i class="fa fa-instagram"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'vimeo':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Vimeo', 'jnews', 'vimeo' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_vimeo">
                                            <i class="fa fa-vimeo-square"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'youtube':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Youtube', 'jnews', 'youtube' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_youtube">
                                            <i class="fa fa-youtube-play"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'vk':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'VK', 'jnews', 'vk' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_vk">
                                            <i class="fa fa-vk"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'twitch':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Twitch', 'jnews', 'twitch' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_twitch">
                                            <i class="fa fa-twitch"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'reddit':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Reddit', 'jnews', 'reddit' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_reddit">
                                            <i class="fa fa-reddit"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'weibo':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Weibo', 'jnews', 'weibo' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_weibo">
                                            <i class="fa fa-weibo"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'stumbleupon':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'StumbleUpon', 'jnews', 'stumbleupon' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_stumbleupon">
                                            <i class="fa fa-stumbleupon"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'telegram':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Telegram', 'jnews', 'telegram' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_telegram">
                                            <i class="fa fa-telegram"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'rss':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'RSS', 'jnews', 'rss' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_rss">
                                            <i class="fa fa-rss"></i>
                                            ' . $label . '
                                        </a>';
								break;

							case 'line':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Line', 'jnews', 'line' ) . '</span>' : '';

								$icon    = jnews_get_svg( 'line' );
								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_line_chat">
								<i class="fa fa-line"><span class="jeg-icon icon-line">' . $icon . '</span></i>
											' . $label . '
										</a>';
								break;

							case 'tiktok':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'TikTok', 'jnews', 'tiktok' ) . '</span>' : '';

								$icon    = jnews_get_svg( 'tiktok' );
								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_line_tiktok">
											<span class="jeg-icon icon-tiktok">' . $icon . '</span>
											' . $label . '
										</a>';
								break;

							case 'twitter':
								$icon  = jnews_get_svg( 'twitter' );
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Twitter', 'jnews', 'twitter' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_twitter">
											<i class="fa fa-twitter"><span class="jeg-icon icon-twitter">' . $icon . '</span></i>
											' . $label . '
										</a>';
								break;

							case 'snapchat':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Snapchat', 'jnews', 'snapchat' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_snapchat">
											<i class="fa fa-snapchat-ghost"></i>
											' . $label . '
										</a>';

							case 'discord':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Discord', 'jnews', 'discord' ) . '</span>' : '';

								$icon    = jnews_get_svg( 'discord' );
								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_discord_chat">
								<i class="fa fa-discord"><span class="jeg-icon icon-discord">' . $icon . '</span></i>
											' . $label . '
										</a>';
								break;

							case 'odnoklassniki':
								$label = ( isset( $verticalsocial ) && $verticalsocial ) ? '<span>' . jnews_return_translation( 'Odnoklassniki', 'jnews', 'odnoklassniki' ) . '</span>' : '';

								$output .= '<a href="' . $social->social_url . '" target="_blank" rel="external noopener nofollow" class="jeg_odnoklassniki">
                                            <i class="fa fa-odnoklassniki"><span></span></i>
                                            ' . $label . '
                                        </a>';
								break;
						}
					}
				}
			}
		}

		if ( isset( $verticalsocial ) && ! $verticalsocial ) {
			$align = ( isset( $align ) && $align ) ? 'jeg_aligncenter' : '';
		} else {
			$align = '';
		}

		?>

		<div class="jeg_social_wrap <?php echo esc_attr( $align ); ?>">
			<?php if ( isset( $beforesocial ) && ! empty( $beforesocial ) ) : ?>
				<p>
					<?php echo wp_kses( $beforesocial, wp_kses_allowed_html() ); ?>
				</p>
			<?php endif; ?>

			<div class="socials_widget <?php echo ( isset( $verticalsocial ) && $verticalsocial ) ? 'vertical_social' : ''; ?>  <?php echo esc_attr( $widgetstyle ); ?>">
				<?php echo jnews_sanitize_output( $output ); ?>
			</div>

			<?php if ( isset( $aftersocial ) && ! empty( $aftersocial ) ) : ?>
				<p>
					<?php echo wp_kses( $aftersocial, wp_kses_allowed_html() ); ?>
				</p>
			<?php endif; ?>
			<?php echo "<style scoped>{$inline_css}</style>"; ?>
		</div>

		<?php
	}
}
