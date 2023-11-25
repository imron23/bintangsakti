<?php
/**
 * @author : Jegtheme
 */

if ( ! function_exists( 'is_elementor_editor' ) ) {
	/**
	 * Check if the current page is elementor editor
	 */
	function is_elementor_editor() {
		return is_admin() && ( isset( $_GET['action'] ) && sanitize_text_field( $_GET['action'] ) === 'elementor' );
	}
}

if ( ! function_exists( 'jnews_home_url_multilang' ) ) {
	/**
	 * Get Home URL for Multilanguage
	 */
	function jnews_home_url_multilang( $path = '', $scheme = null ) {
		if ( function_exists( 'pll_current_language' ) ) {
			if ( isset( $path[0] ) && $path[0] !== '/' ) {
				$path = '/' . $path;
			}

			$polylang_setting = get_option( 'polylang', array() );
			$default_lang     = $polylang_setting['default_lang'];
			$current_lang     = pll_current_language();

			if ( isset( $polylang_setting['hide_default'] ) && $polylang_setting['hide_default'] ) {
				if ( $default_lang === $current_lang ) {
					return home_url( $path, $scheme );
				}
			}

			return home_url( $current_lang . $path, $scheme );
		}
		return home_url( $path, $scheme );
	}
}

if ( ! function_exists( 'jnews_get_locale' ) ) {
	function jnews_get_locale() {
		if ( function_exists( 'pll_current_language' ) ) {
			return pll_current_language();
		}

		return get_locale();
	}
}

add_filter( 'jnews_empty_image', 'jnews_default_empty_image' );

if ( ! function_exists( 'jnews_default_empty_image' ) ) {
	function jnews_default_empty_image( $image ) {

		if ( get_theme_mod( 'jnews_empty_base64', false ) ) {
			$image = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		} else {
			$image = get_parent_theme_file_uri( 'assets/img/jeg-empty.png' );
		}

		return $image;
	}
}


if ( ! function_exists( 'jeg_get_version' ) ) {
	function jeg_get_version() {
		return false;
	}
}

if ( ! function_exists( 'jnews_server_info' ) ) {
	function jnews_server_info() {
		if ( function_exists( 'jeg_server_info' ) ) {
			return jeg_server_info();
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_plugin_active' ) ) {
	function jnews_plugin_active( $class, $slug ) {
		if ( function_exists( 'jeg_plugin_active' ) ) {
			return jeg_plugin_active( $class, $slug );
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_admin_topbar_menu' ) ) {
	function jnews_admin_topbar_menu( $class, $priority = 10 ) {
		if ( function_exists( 'jeg_admin_topbar_menu' ) ) {
			jeg_admin_topbar_menu( $class, $priority );
		}
	}
}

if ( ! function_exists( 'jnews_register_post_type' ) ) {
	function jnews_register_post_type( $slug, $args ) {
		if ( function_exists( 'jeg_register_post_type' ) ) {
			jeg_register_post_type( $slug, $args );
		}
	}
}

if ( ! function_exists( 'jnews_register_taxonomy' ) ) {
	function jnews_register_taxonomy( $slug, $post_type, $args ) {
		if ( function_exists( 'jeg_register_taxonomy' ) ) {
			jeg_register_taxonomy( $slug, $post_type, $args );
		}
	}
}

if ( ! function_exists( 'jnews_register_widget_module' ) ) {
	function jnews_register_widget_module( $args ) {
		if ( function_exists( 'jeg_register_widget_module' ) ) {
			jeg_register_widget_module( $args );
		}
	}
}

if ( ! function_exists( 'jnews_remove_filters' ) ) {
	function jnews_remove_filters( $tag, $function_to_remove, $priority = 10 ) {
		if ( function_exists( 'jeg_remove_filters' ) ) {
			jeg_remove_filters( $tag, $function_to_remove, $priority );
		}
	}
}

if ( ! function_exists( 'jnews_is_emails' ) ) {
	function jnews_is_emails( $value ) {
		if ( function_exists( 'jeg_is_emails' ) ) {
			return jeg_is_emails( $value );
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_load_resource_limit' ) ) {
	function jnews_load_resource_limit() {
		return apply_filters( 'jnews_load_resource_limit', 50 );
	}
}

if ( ! function_exists( 'vp_metabox' ) ) {
	function vp_metabox( $key, $default = null, $post_id = null ) {
		return false;
	}
}

/*** Vafpress whitelist function */
if ( class_exists( 'VP_Security' ) ) {
	VP_Security::instance()->whitelist_function( 'jnews_get_categories_selectize' );
}

if ( ! function_exists( 'jnews_get_categories_selectize' ) ) {
	function jnews_get_categories_selectize() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_categories_count();
			$limit = jnews_load_resource_limit();

			if ( (int) $count <= $limit ) {
				$categories = JNews\Util\Cache::get_categories();
				$walker     = new \JNews\Walker\SelectizeWalker();
				$walker->walk( $categories, 3 );

				foreach ( $walker->cache as $value ) {
					$result[] = array(
						'value' => $value['id'],
						'label' => array( $value['title'], $value['depth'] ),
					);
				}
			}
		}

		return $result;
	}
}

if ( class_exists( 'VP_Security' ) ) {
	VP_Security::instance()->whitelist_function( 'jnews_get_categories' );
}

if ( ! function_exists( 'jnews_get_categories' ) ) {
	function jnews_get_categories() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_categories_count();
			$limit = jnews_load_resource_limit();

			if ( (int) $count <= $limit ) {
				$categories = JNews\Util\Cache::get_categories();
				$walker     = new \JNews\Walker\CategoryMetaboxWalker();
				$walker->walk( $categories, 3 );

				foreach ( $walker->cache as $value ) {
					$result[] = array(
						'value' => $value['id'],
						'label' => $value['title'],
					);
				}
			}
		}

		return $result;
	}
}

if ( class_exists( 'VP_Security' ) ) {
	VP_Security::instance()->whitelist_function( 'jnews_get_sidebar' );
}

if ( ! function_exists( 'jnews_get_sidebar ' ) ) {
	function jnews_get_sidebar() {
		$result = array();

		$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

		if ( $all_sidebar ) {
			foreach ( $all_sidebar as $key => $value ) {
				$result[] = array(
					'value' => $key,
					'label' => $value,
				);
			}
		}

		return $result;
	}
}

if ( class_exists( 'VP_Security' ) ) {
	VP_Security::instance()->whitelist_function( 'jnews_get_all_author_loop' );
}

if ( ! function_exists( 'jnews_get_all_author_loop' ) ) {
	function jnews_get_all_author_loop() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_count_users();
			$limit = jnews_load_resource_limit();

			if ( $count['total_users'] <= $limit ) {
				$users = JNews\Util\Cache::get_users();

				foreach ( $users as $user ) {
					$result[] = array(
						'value' => $user->ID,
						'label' => $user->display_name,
					);
				}
			}
		}

		return $result;
	}
}

if ( class_exists( 'VP_Security' ) ) {
	VP_Security::instance()->whitelist_function( 'jnews_get_all_tag_loop' );
}

if ( ! function_exists( 'jnews_get_all_tag_loop' ) ) {
	function jnews_get_all_tag_loop() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_tags_count();
			$limit = jnews_load_resource_limit();

			if ( (int) $count <= $limit ) {
				if ( $terms = JNews\Util\Cache::get_tags() ) {
					foreach ( $terms as $term ) {
						$result[] = array(
							'value' => $term->term_id,
							'label' => $term->name,
						);
					}
				}
			}
		}

		return $result;
	}
}


/**
 * Get JNews option
 *
 * @param $setting
 * @param $default
 *
 * @return mixed
 */
if ( ! function_exists( 'jnews_get_option' ) ) {
	function jnews_get_option( $setting, $default = null ) {
		$options = get_option( 'jnews_option', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return $value;
	}
}

/**
 * Update JNews option
 *
 * @param $setting
 * @param $default
 *
 * @return mixed
 */
if ( ! function_exists( 'jnews_update_option' ) ) {
	function jnews_update_option( $setting, $value ) {
		$options             = get_option( 'jnews_option', array() );
		$options[ $setting ] = $value;
		update_option( 'jnews_option', $options );
	}
}

if ( ! function_exists( 'jnews_get_all_custom_archive_template' ) ) {

	function jnews_get_all_custom_archive_template() {
		$post = get_posts(
			array(
				'posts_per_page' => - 1,
				'post_type'      => 'archive-template',
			)
		);

		$template   = array();
		$template[] = esc_html__( 'Choose Custom Template', 'jnews' );

		if ( $post ) {
			foreach ( $post as $value ) {
				$template[ $value->ID ] = $value->post_title;
			}
		}

		return $template;
	}
}

if ( ! function_exists( 'jnews_categories_drop' ) ) {
	function jnews_categories_drop() {
		$result = array();

		$categories = get_categories(
			array(
				'hide_empty'   => false,
				'hierarchical' => true,
			)
		);

		$walker = new \JNews\Walker\CategoryMetaboxWalker();
		$walker->walk( $categories, 3 );

		$result[] = '';

		foreach ( $walker->cache as $value ) {
			$result[ $value['id'] ] = $value['title'];
		}

		return $result;
	}
}

if ( ! function_exists( 'jnews_category_menu_icon' ) ) {
	function jnews_category_menu_icon() {
		return array(
			''       => 'Choose icon',
			'search' => 'Search',
			'heart'  => 'Heart',
			'star'   => 'Star',
		);
	}
}

/**
 * @param $post_id
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_rating' ) ) {
	function jnews_generate_rating( $post_id, $class = null ) {
		return apply_filters( 'jnews_review_generate_rating', '', $post_id, $class );
	}
}

/**
 * @param $post_id
 *
 * @return bool
 */
if ( ! function_exists( 'jnews_is_review' ) ) {
	function jnews_is_review( $post_id ) {
		return apply_filters( 'jnews_review_enable_review', false, $post_id );
	}
}


/**
 * Encode URL by Post ID
 *
 * @param $post_id
 *
 * @return string
 */
if ( ! function_exists( 'jnews_encode_url' ) ) {
	function jnews_encode_url( $post_id ) {
		$url = get_permalink( $post_id );

		return urlencode( $url );
	}
}

/**
 * Format Number
 *
 * @param $total
 *
 * @return string
 */
if ( ! function_exists( 'jnews_number_format' ) ) {
	function jnews_number_format( $total ) {
		if ( $total > 1000000 ) {
			$total = round( $total / 1000000, 1 ) . 'M';
		} elseif ( $total > 1000 ) {
			$total = round( $total / 1000, 1 ) . 'k';
		}

		return $total;
	}
}


if ( ! function_exists( 'jnews_get_shortcode_name_from_option' ) ) {
	function jnews_get_shortcode_name_from_option( $class ) {
		$mod = explode( '\\', $class );

		if ( isset( $mod[3] ) ) {
			$module = str_replace( '_Option', '', $mod[0] . '_' . $mod[3] );
		} else {
			$module = $class;
		}

		$module = strtolower( $module );

		return apply_filters( 'jnews_get_shortcode_name_from_option', $module, $class );
	}
}


if ( ! function_exists( 'jnews_get_option_class_from_shortcode' ) ) {
	function jnews_get_option_class_from_shortcode( $name ) {
		$mod   = explode( '_', $name );
		$class = 'JNews\\Module\\' . ucfirst( $mod[1] ) . '\\' . ucfirst( $mod[1] ) . '_' . $mod[2] . '_Option';

		return apply_filters( 'jnews_get_option_class_from_shortcode', $class, $name );
	}
}

if ( ! function_exists( 'jnews_get_shortcode_name_from_view' ) ) {
	function jnews_get_shortcode_name_from_view( $class ) {
		$mod = explode( '\\', $class );

		if ( isset( $mod[3] ) ) {
			$module = str_replace( '_View', '', $mod[0] . '_' . $mod[3] );
		} else {
			$module = $class;
		}

		$module = strtolower( $module );

		return apply_filters( 'jnews_get_shortcode_name_from_view', $module, $class );
	}
}

if ( ! function_exists( 'jnews_get_view_class_from_shortcode' ) ) {
	function jnews_get_view_class_from_shortcode( $name ) {
		$mod   = explode( '_', $name );
		$class = 'JNews\\Module\\' . ucfirst( $mod[1] ) . '\\' . ucfirst( $mod[1] ) . '_' . ucfirst( $mod[2] ) . '_View';

		return apply_filters( 'jnews_get_view_class_from_shortcode', $class, $name );
	}
}


/*** Plugin Helper */
if ( ! function_exists( 'jlog' ) ) {
	function jlog( $var ) {
		echo '<pre>';
		print_r( $var );
		echo '</pre>';
	}
}

/**
 * Primary category
 */
add_filter( 'jnews_get_primary_category_filter', 'jnews_get_primary_category_filter', null, 2 );

if ( ! function_exists( 'jnews_get_primary_category_filter' ) ) {
	function jnews_get_primary_category_filter( $out, $post_id ) {
		return jnews_get_primary_category( $post_id );
	}
}

/**
 * Get primary category ceremony
 *
 * @param $post_id
 *
 * @return mixed|void
 */
if ( ! function_exists( 'jnews_get_primary_category' ) ) {
	function jnews_get_primary_category( $post_id ) {
		$category_id = null;

		if ( get_post_type( $post_id ) === 'post' ) {
			$category = vp_metabox( 'jnews_primary_category.id', null, $post_id );

			if ( ! empty( $category ) ) {
				$category_id = $category;
			} else {
				$categories = array_slice( get_the_category( $post_id ), 0, 1 );
				if ( empty( $categories ) ) {
					return null;
				}
				$category    = array_shift( $categories );
				$category_id = $category->term_id;
			}
		}

		return apply_filters( 'jnews_primary_category', $category_id, $post_id );
	}
}


/**
 * Get all category
 *
 * @return array
 */
if ( ! function_exists( 'jnews_get_all_category' ) ) {
	function jnews_get_all_category() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_categories_count();
			$limit = jnews_load_resource_limit();

			if ( (int) $count <= $limit ) {
				$terms = JNews\Util\Cache::get_categories();
				foreach ( $terms as $term ) {
					$result[ $term->name ] = $term->term_id;
				}
			}
		}

		return $result;
	}
}

/**
 * All Author
 */
if ( ! function_exists( 'jnews_get_all_author' ) ) {
	function jnews_get_all_author() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_count_users();
			$limit = jnews_load_resource_limit();

			if ( $count['total_users'] <= $limit ) {
				$users = JNews\Util\Cache::get_users();

				foreach ( $users as $user ) {
					$result[ $user->display_name ] = $user->ID;
				}
			}
		}

		return $result;
	}
}


/**
 * All Menu
 */
if ( ! function_exists( 'jnews_get_all_menu' ) ) {
	function jnews_get_all_menu() {
		$result = array();

		if ( is_admin() ) {
			if ( $menus = JNews\Util\Cache::get_menu() ) {
				foreach ( $menus as $menu ) {
					$result[ $menu->name ] = $menu->term_id;
				}
			}
		}

		return $result;
	}
}

/**
 * All Package
 */
if ( ! function_exists( 'jnews_get_all_package' ) ) {
	function jnews_get_all_package() {
		$result = array();

		if ( is_admin() ) {
			if ( class_exists( '\JNews_Frontend_Package' ) ) {
				$jnews_frontend_package = \JNews_Frontend_Package::getInstance();
				$result                 = $jnews_frontend_package->get_package_list();
			}
		}

		return $result;
	}
}

/**
 * All Tag
 */
if ( ! function_exists( 'jnews_get_all_tag' ) ) {
	function jnews_get_all_tag() {
		$result = array();

		if ( is_admin() ) {
			$count = JNews\Util\Cache::get_tags_count();
			$limit = jnews_load_resource_limit();

			if ( (int) $count <= $limit ) {
				$terms = JNews\Util\Cache::get_tags();

				foreach ( $terms as $term ) {
					$result[ $term->name ] = $term->term_id;
				}
			}
		}

		return $result;
	}
}

/**
 * @return array
 */
if ( ! function_exists( 'jnews_get_all_post_type' ) ) {
	function jnews_get_all_post_type() {
		$post_types = JNews\Util\Cache::get_exclude_post_type();

		if ( ! empty( $post_types ) && is_array( $post_types ) ) {

			foreach ( $post_types as $key => $label ) {

				if ( ! in_array( $key, array( 'post', 'page' ) ) ) {

					if ( ! get_theme_mod( 'jnews_enable_cpt_' . $key, true ) ) {
						unset( $post_types[ $key ] );
					}
				}
			}
		}

		return $post_types;
	}
}

/**
 * @return false|string
 */
if ( ! function_exists( 'jnews_get_theme_version' ) ) {
	function jnews_get_theme_version() {
		$theme = wp_get_theme();

		return $theme->get( 'Version' );
	}
}


/**
 * Generate Social Icon
 *
 * @param bool|true $echo
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_social_icon' ) ) {
	function jnews_generate_social_icon( $echo = true ) {
		/** @var array $socials */
		$socials      = get_theme_mod(
			'jnews_social_icon',
			array(
				array(
					'social_icon' => 'facebook',
					'social_url'  => 'http://facebook.com',
				),
				array(
					'social_icon' => 'twitter',
					'social_url'  => 'http://twitter.com',
				),
			)
		);
		$socialstring = array();
		foreach ( $socials as $social ) {
			switch ( $social['social_icon'] ) {
				case 'facebook':
					$icon = 'fa fa-facebook';
					break;
				case 'twitter':
					$icon = 'fa fa-twitter';
					break;
				case 'linkedin':
					$icon = 'fa fa-linkedin';
					break;
				case 'pinterest':
					$icon = 'fa fa-pinterest';
					break;
				case 'behance':
					$icon = 'fa fa-behance';
					break;
				case 'github':
					$icon = 'fa fa-github';
					break;
				case 'flickr':
					$icon = 'fa fa-flickr';
					break;
				case 'tumblr':
					$icon = 'fa fa-tumblr';
					break;
				case 'dribbble':
					$icon = 'fa fa-dribbble';
					break;
				case 'soundcloud':
					$icon = 'fa fa-soundcloud';
					break;
				case 'instagram':
					$icon = 'fa fa-instagram';
					break;
				case 'vimeo':
					$icon = 'fa fa-vimeo';
					break;
				case 'youtube':
					$icon = 'fa fa-youtube-play';
					break;
				case 'vk':
					$icon = 'fa fa-vk';
					break;
				case 'reddit':
					$icon = 'fa fa-reddit';
					break;
				case 'rss':
					$icon = 'fa fa-rss';
					break;
				case 'weibo':
					$icon = 'fa fa-weibo';
					break;
				case 'line':
					$icon = 'fa fa-line';
					break;
				case 'odnoklassniki':
					$icon = 'fa fa-odnoklassniki';
					break;
				case 'tiktok':
					$icon = 'fa fa-tiktok';
					break;
				case 'snapchat':
					$icon = 'fa fa-snapchat-ghost';
					break;
				case 'discord':
					$icon = 'fa fa-discord';
					break;
				case 'whatsapp':
					$icon = 'fa fa-whatsapp';
					break;
				default:
					$icon = '';
					break;
			}

			if ( ! empty( $icon ) ) {
				$social_url     = ! empty( $social['social_url'] ) ? $social['social_url'] : '';
				$socialstring[] = "<li><a href=\"{$social_url}\" target='_blank'><i class=\"{$icon}\"></i></a></li>";
			}
		}

		if ( $echo ) {
			echo implode( '', $socialstring );
		} else {
			return implode( '', $socialstring );
		}
	}
}

/**
 * Generate Social Icon Block
 *
 * @param bool|true $echo
 * @param bool|false $withtitle
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_social_icon_block' ) ) {
	function jnews_generate_social_icon_block( $echo = true, $withtitle = false ) {

		$socials      = get_theme_mod(
			'jnews_social_icon',
			array(
				array(
					'social_icon' => 'facebook',
					'social_url'  => 'http://facebook.com',
				),
				array(
					'social_icon' => 'twitter',
					'social_url'  => 'http://twitter.com',
				),
			)
		);
		$socialstring = array();

		foreach ( $socials as $social ) {
			switch ( $social['social_icon'] ) {
				case 'facebook':
					$icon  = 'fa fa-facebook';
					$class = 'jeg_facebook';
					$title = jnews_return_translation( 'Facebook', 'jnews', 'facebook' );
					break;
				case 'twitter':
					$icon  = 'fa fa-twitter'; // currently there is no twiiter x in font awesome 4.7
					$class = 'jeg_twitter';
					$title = jnews_return_translation( 'Twitter', 'jnews', 'twitter' );
					break;
				case 'linkedin':
					$icon  = 'fa fa-linkedin';
					$class = 'jeg_linkedin';
					$title = jnews_return_translation( 'LinkedIn', 'jnews', 'linkedin' );
					break;
				case 'pinterest':
					$icon  = 'fa fa-pinterest';
					$class = 'jeg_pinterest';
					$title = jnews_return_translation( 'Pinterest', 'jnews', 'pinterest' );
					break;
				case 'behance':
					$icon  = 'fa fa-behance';
					$class = 'jeg_behance';
					$title = jnews_return_translation( 'Behance', 'jnews', 'behance' );
					break;
				case 'github':
					$icon  = 'fa fa-github';
					$class = 'jeg_github';
					$title = jnews_return_translation( 'Github', 'jnews', 'github' );
					break;
				case 'flickr':
					$icon  = 'fa fa-flickr';
					$class = 'jeg_flickr';
					$title = jnews_return_translation( 'Flirk', 'jnews', 'flickr' );
					break;
				case 'tumblr':
					$icon  = 'fa fa-tumblr';
					$class = 'jeg_tumblr';
					$title = jnews_return_translation( 'Tumblr', 'jnews', 'tumblr' );
					break;
				case 'dribbble':
					$icon  = 'fa fa-dribbble';
					$class = 'jeg_dribbble';
					$title = jnews_return_translation( 'Dribbble', 'jnews', 'dribbble' );
					break;
				case 'soundcloud':
					$icon  = 'fa fa-soundcloud';
					$class = 'jeg_soundcloud';
					$title = jnews_return_translation( 'Soundcloud', 'jnews', 'soundcloud' );
					break;
				case 'instagram':
					$icon  = 'fa fa-instagram';
					$class = 'jeg_instagram';
					$title = jnews_return_translation( 'Instagram', 'jnews', 'instagram' );
					break;
				case 'vimeo':
					$icon  = 'fa fa-vimeo';
					$class = 'jeg_vimeo';
					$title = jnews_return_translation( 'Vimeo', 'jnews', 'vimeo' );
					break;
				case 'youtube':
					$icon  = 'fa fa-youtube-play';
					$class = 'jeg_youtube';
					$title = jnews_return_translation( 'Youtube', 'jnews', 'youtube' );
					break;
				case 'twitch':
					$icon  = 'fa fa-twitch';
					$class = 'jeg_twitch';
					$title = jnews_return_translation( 'Twitch', 'jnews', 'youtube' );
					break;
				case 'vk':
					$icon  = 'fa fa-vk';
					$class = 'jeg_vk';
					$title = jnews_return_translation( 'VK', 'jnews', 'vk' );
					break;
				case 'reddit':
					$icon  = 'fa fa-reddit';
					$class = 'jeg_reddit';
					$title = jnews_return_translation( 'Reddit', 'jnews', 'reddit' );
					break;
				case 'weibo':
					$icon  = 'fa fa-weibo';
					$class = 'jeg_weibo';
					$title = jnews_return_translation( 'Weibo', 'jnews', 'weibo' );
					break;
				case 'stumbleupon':
					$icon  = 'fa fa-stumbleupon';
					$class = 'jeg_stumbleupon';
					$title = jnews_return_translation( 'StumbleUpon', 'jnews', 'stumbleupon' );
					break;
				case 'telegram':
					$icon  = 'fa fa-telegram';
					$class = 'jeg_telegram';
					$title = jnews_return_translation( 'Telegram', 'jnews', 'telegram' );
					break;
				case 'rss':
					$icon  = 'fa fa-rss';
					$class = 'jeg_rss';
					$title = jnews_return_translation( 'RSS', 'jnews', 'rss' );
					break;
				case 'wechat':
					$icon  = 'fa fa-wechat';
					$class = 'jeg_wechat';
					$title = jnews_return_translation( 'WeChat', 'jnews', 'wechat' );
					break;
				case 'odnoklassniki':
					$icon  = 'fa fa-odnoklassniki';
					$class = 'jeg_odnoklassniki';
					$title = jnews_return_translation( 'Odnoklassniki', 'jnews', 'odnoklassniki' );
					break;
				case 'tiktok':
					$icon  = 'jeg-icon icon-tiktok'; // currently there is no fa-tiktok in font awesome 4.7
					$class = 'jeg_tiktok';
					$title = jnews_return_translation( 'TikTok', 'jnews', 'tiktok' );
					break;
				case 'snapchat':
					$icon  = 'fa fa-snapchat-ghost';
					$class = 'jeg_snapchat';
					$title = jnews_return_translation( 'Snapchat', 'jnews', 'snapchat' );
					break;
				case 'line':
					$icon  = 'fa fa-line'; // currently there is no fa-line in font awesome 4.7
					$class = 'jeg_line_chat';
					$title = jnews_return_translation( 'Line', 'jnews', 'line' );
					break;
				case 'discord':
					$icon  = 'jeg-icon icon-discord'; // currently there is no fa-discord in font awesome 4.7
					$class = 'jeg_discord_chat';
					$title = jnews_return_translation( 'Discord', 'jnews', 'discord' );
					break;
				case 'whatsapp':
					$icon  = 'fa fa-whatsapp';
					$class = 'jeg_whatsapp';
					$title = jnews_return_translation( 'Whatsapp', 'jnews', 'whatsapp' );
					break;
				default:
					$icon = '';
					break;
			}

			if ( ! empty( $icon ) ) {
				$title_string = $withtitle ? "<span>{$title}</span>" : '';
				$social_url   = ! empty( $social['social_url'] ) ? $social['social_url'] : '';

				if ( $class === 'jeg_line_chat' ) {
					/*
					Currently there is no option to use Line icon in Font Awesome 4.7, so this class use SVG icons instead
					*/
					$icon_svg       = jnews_get_svg( 'line' );
					$socialstring[] = "<a href=\"{$social_url}\" target='_blank' rel='external noopener nofollow' class=\"{$class}\"><i class=\"{$icon}\"><span class=\"jeg-icon icon-line\">{$icon_svg}</span></i> {$title_string}</a>";
				} elseif ( $class === 'jeg_tiktok' ) {
					/*
					Currently there is no option to use Line icon in Font Awesome 4.7, so this class use SVG icons instead
					*/
					$icon_svg       = jnews_get_svg( 'tiktok' );
					$socialstring[] = "<a href=\"{$social_url}\" target='_blank' rel='external noopener nofollow' class=\"{$class}\"><span class=\"{$icon}\">{$icon_svg}</span> {$title_string}</a>";
				} elseif ( $class === 'jeg_discord_chat' ) {
					/*
					Currently there is no option to use Line icon in Font Awesome 4.7, so this class use SVG icons instead
					*/
					$icon_svg       = jnews_get_svg( 'discord' );
					$socialstring[] = "<a href=\"{$social_url}\" target='_blank' rel='external noopener nofollow' class=\"{$class}\"><span class=\"{$icon}\">{$icon_svg}</span> {$title_string}</a>";

				} elseif ( $class === 'jeg_twitter' ) {
					/*
					Currently there is no option to use Line icon in Font Awesome 4.7, so this class use SVG icons instead
					*/
					$icon_svg       = jnews_get_svg( 'twitter' );
					$socialstring[] = "<a href=\"{$social_url}\" target='_blank' rel='external noopener nofollow' class=\"{$class}\"><i class=\"{$icon}\"><span class=\"jeg-icon icon-twitter\">{$icon_svg}</span></i> {$title_string}</a>";
				} else {
					$socialstring[] = "<a href=\"{$social_url}\" target='_blank' rel='external noopener nofollow' class=\"{$class}\"><i class=\"{$icon}\"></i> {$title_string}</a>";
				}
			}
		}

		if ( $echo ) {
			echo implode( '', $socialstring );
		}

		return implode( '', $socialstring );
	}
}

/**
 * General header social handler
 */
if ( ! function_exists( 'jnews_header_social' ) ) {

	add_action( 'jnews_header_social', 'jnews_header_social' );

	function jnews_header_social() {
		if ( ! defined( 'JNEWS_ESSENTIAL' ) ) {
			echo wp_kses( __( 'Social icon element need <strong>JNews Essential</strong> plugin to be activated.', 'jnews' ), wp_kses_allowed_html() );
		}
	}
}

/**
 * General footer social handler
 */
if ( ! function_exists( 'jnews_footer_social' ) ) {

	add_action( 'jnews_footer_social', 'jnews_footer_social' );

	function jnews_footer_social( $position ) {
		if ( $position === get_theme_mod( 'jnews_footer_social_position', 'hide' ) && ! defined( 'JNEWS_ESSENTIAL' ) ) {
			echo wp_kses( __( 'Social icon element need <strong>JNews Essential</strong> plugin to be activated.', 'jnews' ), wp_kses_allowed_html() );
		}
	}
}

/**
 * Footer 5 social handler
 */
if ( ! function_exists( 'jnews_footer_5_social' ) ) {

	add_action( 'jnews_footer_5_social', 'jnews_footer_5_social' );

	function jnews_footer_5_social() {
		if ( ! defined( 'JNEWS_ESSENTIAL' ) ) {
			echo wp_kses( __( 'Social icon element need <strong>JNews Essential</strong> plugin to be activated.', 'jnews' ), wp_kses_allowed_html() );
		}
	}
}

/**
 * Footer 7 social handler
 */
if ( ! function_exists( 'jnews_footer_7_social' ) ) {

	add_action( 'jnews_footer_7_social', 'jnews_footer_7_social' );

	function jnews_footer_7_social() {
		if ( ! defined( 'JNEWS_ESSENTIAL' ) ) {
			echo wp_kses( __( 'Social icon element need <strong>JNews Essential</strong> plugin to be activated.', 'jnews' ), wp_kses_allowed_html() );
		}
	}
}

if ( ! function_exists( 'jnews_generate_logo_text' ) ) {
	/**
	 * Generate Logo Text
	 *
	 * @param $logo_text
	 * @param $echo
	 *
	 * @return string
	 */
	function jnews_generate_logo_text( $logo_text, $echo ) {
		$logo      = $logo_text;
		$logo_text = apply_filters( 'jnews_generate_logo_text', $logo, $logo_text );

		if ( $echo ) {
			echo jnews_sanitize_by_pass( $logo_text );
		}

		return $logo_text;
	}
}

/**
 * Generate Header Logo
 *
 * @param bool|true $echo
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_header_logo' ) ) {
	function jnews_generate_header_logo( $echo = true, $heading = false ) {
		if ( get_theme_mod( 'jnews_header_logo_type', 'image' ) === 'image' ) {
			$logo        = get_theme_mod( 'jnews_header_logo', get_parent_theme_file_uri( 'assets/img/logo.png' ) );
			$logo_retina = get_theme_mod( 'jnews_header_logo_retina', get_parent_theme_file_uri( 'assets/img/logo@2x.png' ) );
			$alt         = get_theme_mod( 'jnews_header_logo_alt', get_bloginfo( 'name' ) );

			/*Dark logo*/
			$logo_dark        = get_theme_mod( 'jnews_header_logo_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode.png' ) );
			$logo_retina_dark = get_theme_mod( 'jnews_header_logo_retina_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode@2x.png' ) );

			if ( $heading ) {
				ob_start();
			}
			$logo_image = JNews\Image\Image::generate_image_retina( $logo, $logo_retina, $alt, $echo, $logo_dark, $logo_retina_dark );

			if ( $heading ) {
				$logo_image = ob_get_contents();
				ob_end_clean();
				$logo_image .= '<span style="border:0;padding:0;margin:0;position:absolute!important;height:1px;width:1px;overflow:hidden;clip:rect(1px 1px 1px 1px);clip:rect(1px,1px,1px,1px);-webkit-clip-path:inset(50%);clip-path:inset(50%);white-space:nowrap">' . get_bloginfo( 'name' ) . '</span>';
				if ( $echo ) {
					echo jnews_sanitize_output( $logo_image );
				}
			}

			return $logo_image;
		} else {
			$logo_text = get_theme_mod( 'jnews_header_logo_text', 'Logo' );

			return jnews_generate_logo_text( $logo_text, $echo );
		}
	}
}

/**
 * Generate Sticky Logo
 *
 * @param bool|true $echo
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_sticky_logo' ) ) {
	function jnews_generate_sticky_logo( $echo = true ) {
		if ( get_theme_mod( 'jnews_sticky_logo_type', 'image' ) === 'image' ) {
			$logo        = get_theme_mod( 'jnews_sticky_menu_logo', get_parent_theme_file_uri( 'assets/img/sticky_logo.png' ) );
			$logo_retina = get_theme_mod( 'jnews_sticky_menu_logo_retina', get_parent_theme_file_uri( 'assets/img/sticky_logo@2x.png' ) );
			$alt         = get_theme_mod( 'jnews_sticky_menu_alt', get_bloginfo( 'name' ) );

			/*Dark logo*/
			$logo_dark        = get_theme_mod( 'jnews_sticky_menu_logo_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode.png' ) );
			$logo_retina_dark = get_theme_mod( 'jnews_sticky_menu_logo_retina_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode@2x.png' ) );

			return JNews\Image\Image::generate_image_retina( $logo, $logo_retina, $alt, $echo, $logo_dark, $logo_retina_dark );
		} else {
			$logo_text = get_theme_mod( 'jnews_sticky_logo_text', 'Logo' );

			return jnews_generate_logo_text( $logo_text, $echo );
		}
	}
}

/**
 * Generate Mobile Logo
 *
 * @param bool|true $echo
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_mobile_logo' ) ) {
	function jnews_generate_mobile_logo( $echo = true ) {
		if ( get_theme_mod( 'jnews_mobile_logo_type', 'image' ) === 'image' ) {
			$logo        = get_theme_mod( 'jnews_mobile_logo', get_parent_theme_file_uri( 'assets/img/logo_mobile.png' ) );
			$logo_retina = get_theme_mod( 'jnews_mobile_logo_retina', get_parent_theme_file_uri( 'assets/img/logo_mobile@2x.png' ) );
			$alt         = get_theme_mod( 'jnews_mobile_logo_alt', get_bloginfo( 'name' ) );

			/*Dark logo*/
			$logo_dark        = get_theme_mod( 'jnews_mobile_logo_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode.png' ) );
			$logo_retina_dark = get_theme_mod( 'jnews_mobile_logo_retina_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode@2x.png' ) );

			return JNews\Image\Image::generate_image_retina( $logo, $logo_retina, $alt, $echo, $logo_dark, $logo_retina_dark );
		} else {
			$logo_text = get_theme_mod( 'jnews_mobile_logo_text', 'Logo' );

			return jnews_generate_logo_text( $logo_text, $echo );
		}
	}
}

/**
 * Generate Footer 7 Logo
 *
 * @param bool|true $echo
 *
 * @return string
 */
if ( ! function_exists( 'jnews_generate_footer_7_logo' ) ) {
	function jnews_generate_footer_7_logo( $echo = true ) {
		$logo        = get_theme_mod( 'jnews_footer_logo', get_parent_theme_file_uri( 'assets/img/logo.png' ) );
		$logo_retina = get_theme_mod( 'jnews_footer_logo_retina', get_parent_theme_file_uri( 'assets/img/logo@2x.png' ) );
		$alt         = get_theme_mod( 'jnews_footer_logo_alt', get_bloginfo( 'name' ) );

		/*Dark logo*/
		$logo_dark        = get_theme_mod( 'jnews_footer_logo_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode.png' ) );
		$logo_retina_dark = get_theme_mod( 'jnews_footer_logo_retina_darkmode', get_parent_theme_file_uri( 'assets/img/logo_darkmode@2x.png' ) );

		return JNews\Image\Image::generate_image_retina( $logo, $logo_retina, $alt, $echo, $logo_dark, $logo_retina_dark );
	}
}

/**
 * Sanitize with allowed html
 *
 * @param $value
 *
 * @return string
 */
if ( ! function_exists( 'jnews_sanitize_allowed_tag' ) ) {
	function jnews_sanitize_allowed_tag( $value ) {
		return wp_kses( $value, wp_kses_allowed_html() );
	}
}

/**
 * Sanitize output with allowed html
 *
 * @param $value
 *
 * @return string
 */
if ( ! function_exists( 'jnews_sanitize_output' ) ) {
	function jnews_sanitize_output( $value ) {
		return $value;
	}
}

/**
 * Format Number
 *
 * @param $total
 *
 * @return string
 */
if ( ! function_exists( 'jnews_format_number' ) ) {
	function jnews_format_number( $total ) {
		if ( $total > 1000000 ) {
			$total = round( $total / 1000000, 1 ) . 'M';
		} elseif ( $total > 1000 ) {
			$total = round( $total / 1000, 1 ) . 'k';
		}

		return $total;
	}
}

/**
 * Check youtube URL
 *
 * @param $url
 *
 * @return string
 */
if ( ! function_exists( 'jnews_check_video_type' ) ) {
	function jnews_check_video_type( $url ) {
		if ( strpos( $url, 'iframe' ) > 0 ) {
			return 'iframe';
		} elseif ( strpos( $url, 'youtube' ) > 0 || strpos( $url, 'youtu.be' ) > 0 ) {
			return 'youtube';
		} elseif ( strpos( $url, 'vimeo' ) > 0 ) {
			return 'vimeo';
		} elseif ( strpos( $url, 'dailymotion' ) > 0 || strpos( $url, 'dai.ly' ) > 0 ) {
			return 'dailymotion';
		} else {
			return 'unknown';
		}
	}
}

/**
 * Get Image Src
 *
 * @param $id
 * @param string $size
 *
 * @return bool
 */
if ( ! function_exists( 'jnews_get_image_src' ) ) {
	function jnews_get_image_src( $id, $size = 'full' ) {
		if ( ! empty( $id ) && ( ctype_digit( $id ) || is_int( $id ) ) ) {
			$image = wp_get_attachment_image_src( $id, $size );

			return $image[0];
		}

		return false;
	}
}

/**
 * Get Image Dimension by Name
 *
 * @param $name
 *
 * @return float
 */
if ( ! function_exists( 'jnews_get_image_dimension_by_name' ) ) {
	function jnews_get_image_dimension_by_name( $name ) {
		$size = explode( '-', $name );
		$size = explode( 'x', $size[1] );

		return jnews_get_image_dimension_by_size( $size[0], $size[1] );
	}
}

/**
 * Get Image Dimension by Size
 *
 * @param $width
 * @param $height
 *
 * @return float
 */
if ( ! function_exists( 'jnews_get_image_dimension_by_size' ) ) {
	function jnews_get_image_dimension_by_size( $width, $height ) {
		return round( $height / $width * 1000 );
	}
}


/**
 * get single post current page
 *
 * @return mixed
 */
if ( ! function_exists( 'jnews_get_post_current_page' ) ) {
	function jnews_get_post_current_page() {
		$page  = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		return max( $page, $paged );
	}
}

/**
 * @return bool
 */
if ( ! function_exists( 'jnews_show_breadcrumb' ) ) {
	function jnews_show_breadcrumb() {
		if ( is_single() ) {
			return get_theme_mod( 'jnews_breadcrumb_show_post', true );
		} elseif ( is_category() ) {
			return get_theme_mod( 'jnews_breadcrumb_show_category', true );
		} elseif ( is_search() ) {
			return get_theme_mod( 'jnews_breadcrumb_show_search', true );
		} elseif ( is_author() ) {
			return get_theme_mod( 'jnews_breadcrumb_show_author', true );
		} elseif ( is_archive() ) {
			return get_theme_mod( 'jnews_breadcrumb_show_archive', true );
		}

		return apply_filters( 'jnews_show_breadcrumb', true );
	}
}

/**
 * Render Breadcrumb
 *
 * @return mixed|string|void
 */
if ( ! function_exists( 'jnews_render_breadcrumb' ) ) {
	function jnews_render_breadcrumb() {
		$type   = get_theme_mod( 'jnews_breadcrumb', 'native' );
		$output = '';

		if ( jnews_show_breadcrumb() ) {
			if ( $type === 'native' ) {
				$output = jnews_native_breadcrumb();
			} elseif ( $type === 'navxt' ) {
				$output = jnews_render_navxt_breadcrumb();
			} elseif ( $type === 'yoast' ) {
				$output = jnews_render_yoast();
			}
		}

		return $output;
	}
}

/**
 * @return bool
 */
if ( ! function_exists( 'jnews_can_render_breadcrumb' ) ) {
	function jnews_can_render_breadcrumb() {
		$type = get_theme_mod( 'jnews_breadcrumb', 'native' );

		if ( $type === 'native' && class_exists( 'JNews_Breadcrumb' ) ) {
			return true;
		}

		if ( $type === 'navxt' && function_exists( 'bcn_display' ) ) {
			return true;
		}

		if ( $type === 'yoast' && function_exists( 'yoast_breadcrumb' ) ) {
			return true;
		}

		return false;
	}
}


/**
 * Call Native Breadcrumb
 *
 * @return mixed|void
 */
if ( ! function_exists( 'jnews_native_breadcrumb' ) ) {
	function jnews_native_breadcrumb() {
		return apply_filters( 'jnews_breadcrumb', '' );
	}
}

/**
 * Navxt Breadcrumb
 *
 * @return string
 */
if ( ! function_exists( 'jnews_render_navxt_breadcrumb' ) ) {
	function jnews_render_navxt_breadcrumb() {
		$output = '<p id="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">';
		if ( function_exists( 'bcn_display' ) ) {
			$output .= bcn_display( true );
		}
		$output .= '</p>';

		return $output;
	}
}

/**
 * Yoast Breadcrumb
 *
 * @return string
 */
if ( ! function_exists( 'jnews_render_yoast' ) ) {
	function jnews_render_yoast() {
		$output = '';

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			ob_start();
			yoast_breadcrumb( '<p id="breadcrumbs">', '</p>', true );
			$output = ob_get_contents();
			ob_end_clean();
		}

		return $output;
	}
}

/**
 * Generate sidebar, but before it, we need to setup those width on module manager first
 *
 * @param $sidebar_name
 * @param int $width
 */
if ( ! function_exists( 'jnews_widget_area' ) ) {
	function jnews_widget_area( $sidebar_name, $width = 4 ) {
		if ( is_active_sidebar( $sidebar_name ) ) {
			do_action( 'jnews_module_set_width', $width );
			dynamic_sidebar( $sidebar_name );
			do_action( 'jnews_reset_column_width' );
		}
	}
}

/**
 * Copyright Default Text
 *
 * @return string
 */
if ( ! function_exists( 'jnews_get_footer_copyright_text' ) ) {
	function jnews_get_footer_copyright_text() {
		return '&copy; ' . date( 'Y' ) . ' <a href="http://jegtheme.com" title="Premium WordPress news &amp; magazine theme">JNews</a> - Premium WordPress news &amp; magazine theme by <a href="http://jegtheme.com" title="Jegtheme">Jegtheme</a>.';
	}
}

/**
 * Footer copyright
 */
if ( ! function_exists( 'jnews_get_footer_copyright' ) ) {
	function jnews_get_footer_copyright() {
		$copyright = wp_kses( get_theme_mod( 'jnews_footer_copyright', jnews_get_footer_copyright_text() ), wp_kses_allowed_html() );

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$copyright = jnews_return_polylang( $copyright );
		}

		if ( function_exists( 'icl_t' ) ) {
			$copyright = icl_t( 'jnews', $copyright, $copyright );
		}

		return do_shortcode( $copyright );
	}
}

/**
 * Footer menu title
 */
if ( ! function_exists( 'jnews_get_footer_menu_title' ) ) {
	function jnews_get_footer_menu_title() {
		$menu_title = wp_kses( get_theme_mod( 'jnews_footer_menu_title', 'Navigate Site' ), wp_kses_allowed_html() );

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$menu_title = jnews_return_polylang( $menu_title );
		}

		if ( function_exists( 'icl_t' ) ) {
			$menu_title = icl_t( 'jnews', $menu_title, $menu_title );
		}

		return $menu_title;
	}
}

/**
 * Footer social title
 */
if ( ! function_exists( 'jnews_get_footer_social_title' ) ) {
	function jnews_get_footer_social_title() {
		$social_title = wp_kses( get_theme_mod( 'jnews_footer_social_title', 'Follow Us' ), wp_kses_allowed_html() );

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$social_title = jnews_return_polylang( $social_title );
		}

		if ( function_exists( 'icl_t' ) ) {
			$social_title = icl_t( 'jnews', $social_title, $social_title );
		}

		return $social_title;
	}
}

/**
 * Polylang Integration
 */
if ( ! function_exists( 'jnews_return_polylang' ) ) {
	function jnews_return_polylang( $text ) {
		return apply_filters( 'jnews_translate_polylang', $text );
	}
}

/**
 * Post Class
 */
if ( ! function_exists( 'jnews_post_class' ) ) {
	function jnews_post_class( $class = '', $post_id = null ) {
		$post_type = get_post_type( $post_id );
		// Post Format.
		if ( $post_type && post_type_supports( $post_type, 'post-formats' ) ) {
			$post_format = get_post_format( $post_id );

			if ( $post_format && ! is_wp_error( $post_format ) ) {
				$class .= ' format-' . sanitize_html_class( $post_format );
			} else {
				$class .= ' format-standard';
			}
		}

		return 'class="' . $class . '"';
	}
}


/**
 * Footer 4 text
 *
 * @return string
 */
if ( ! function_exists( 'jnews_footer_text' ) ) {
	function jnews_footer_text() {
		return __( '<strong> Call us: +1 234 JEG THEME </strong>', 'jnews' );
	}
}

if ( ! function_exists( 'jnews_custom_text' ) ) {
	/**
	 * This function will help to get a custom text
	 *
	 * @param string $text The text will be customize.
	 *
	 * @return string
	 */
	function jnews_custom_text( $text = '' ) {
		$result = '';
		if ( ! empty( $text ) ) {
			$ver    = array();
			$length = ( strlen( $text ) - 1 );
			for ( $iteration = $length; $iteration >= 0; $iteration-- ) {
				$ver[] = $text[ $iteration ];
			}
			$result = ! empty( $ver ) ? implode( '', $ver ) : '';
		}

		return $result;
	}
}

/**
 * @return array|string
 */
if ( ! function_exists( 'jnews_paging_navigation' ) ) {
	function jnews_paging_navigation( $args, $total_page = false, $column_class = '' ) {
		global $wp_query, $wp_rewrite;

		// Setting up default values based on the current URL.
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$url_parts    = explode( '?', $pagenum_link );

		// Get max pages and current page out of the current query, if available.
		$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
		$total   = $total_page ? $total_page : $total;
		$current = jnews_get_post_current_page();

		// Append the format placeholder to the base URL.
		$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

		// URL base depends on permalink settings.
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		$defaults = array(
			'base'               => $pagenum_link,
			'format'             => $format,
			'total'              => $total,
			'current'            => $current,
			'show_all'           => false,
			'prev_next'          => true,
			'prev_text'          => jnews_return_translation( 'Previous', 'jnews', 'previous' ),
			'next_text'          => jnews_return_translation( 'Next', 'jnews', 'next' ),
			'end_size'           => 1,
			'mid_size'           => 1,
			'type'               => 'plain',
			'add_args'           => array(), // array of query args to add
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => '',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( ! is_array( $args['add_args'] ) ) {
			$args['add_args'] = array();
		}

		// Merge additional query vars found in the original URL into 'add_args' array.
		if ( isset( $url_parts[1] ) ) {
			// Find the format argument.
			$format_args  = $url_query_args = array();
			$format       = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
			$format_query = isset( $format[1] ) ? $format[1] : '';
			wp_parse_str( $format_query, $format_args );

			// Find the query args of the requested URL.
			wp_parse_str( $url_parts[1], $url_query_args );

			// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
			foreach ( $format_args as $format_arg => $format_arg_value ) {
				unset( $url_query_args[ $format_arg ] );
			}

			$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
		}

		// Who knows what else people pass in $args
		$total = (int) $args['total'];
		if ( $total < 2 ) {
			return;
		}
		$current  = (int) $args['current'];
		$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
		if ( $end_size < 1 ) {
			$end_size = 1;
		}
		$mid_size = (int) $args['mid_size'];
		if ( $mid_size < 0 ) {
			$mid_size = 2;
		}
		$add_args   = $args['add_args'];
		$r          = '';
		$page_links = array();
		$dots       = false;

		if ( $args['prev_next'] && $current && 1 < $current ) :
			$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current - 1, $link );
			if ( $add_args ) {
				$link = add_query_arg( $add_args, $link );
			}
			$link .= $args['add_fragment'];

			/**
			 * Filters the paginated links for the given archive pages.
			 *
			 * @param string $link The paginated link URL.
			 *
			 * @since 3.0.0
			 */
			$page_links[] = '<a class="page_nav prev" data-id="' . ( $current - 1 ) . '" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="navtext">' . $args['prev_text'] . '</span></a>';
		endif;
		for ( $n = 1; $n <= $total; $n++ ) :
			if ( $n == $current ) :
				$page_links[] = "<span class='page_number active'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . '</span>';
				$dots         = true;
			elseif ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
					$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
					$link = str_replace( '%#%', $n, $link );
				if ( $add_args ) {
					$link = add_query_arg( $add_args, $link );
				}
					$link .= $args['add_fragment'];

					/** This filter is documented in wp-includes/general-template.php */
					$page_links[] = "<a class='page_number' data-id='{$n}' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . '</a>';
					$dots         = true;
				elseif ( $dots && ! $args['show_all'] ) :
					$page_links[] = '<span class="page_number dots">' . __( '&hellip;', 'jnews' ) . '</span>';
					$dots         = false;
			endif;
		endfor;
		if ( $args['prev_next'] && $current && ( $current < $total || - 1 == $total ) ) :
			$link = str_replace( '%_%', $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current + 1, $link );
			if ( $add_args ) {
				$link = add_query_arg( $add_args, $link );
			}
			$link .= $args['add_fragment'];

			/** This filter is documented in wp-includes/general-template.php */
			$page_links[] = '<a class="page_nav next" data-id="' . ( $current + 1 ) . '" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span class="navtext">' . $args['next_text'] . '</span></a>';
		endif;

		switch ( $args['type'] ) {
			case 'array':
				return $page_links;

			case 'list':
				$r .= "<ul class='page-numbers'>\n\t<li>";
				$r .= join( "</li>\n\t<li>", $page_links );
				$r .= "</li>\n</ul>\n";
				break;

			default:
				$nav_class = 'jeg_page' . $args['pagination_mode'];
				$nav_align = 'jeg_align' . $args['pagination_align'];
				$nav_text  = $args['pagination_navtext'] ? '' : 'no_navtext';
				$nav_info  = $args['pagination_pageinfo'] ? '' : 'no_pageinfo';

				$paging_text = sprintf( jnews_return_translation( 'Page %s of %s', 'jnews', 'page_s_of_s' ), $current, $total );

				$r = join( "\n", $page_links );
				$r = "<div class=\"jeg_navigation jeg_pagination {$column_class} {$nav_class} {$nav_align} {$nav_text} {$nav_info}\">
                    <span class=\"page_info\">{$paging_text}</span>
                    {$r}
                </div>";
				break;
		}

		return $r;
	}
}


if ( ! function_exists( 'jnews_excerpt_more ' ) ) {
	function jnews_excerpt_more() {
		return ' ...';
	}
}

if ( ! function_exists( 'jnews_excerpt_length ' ) ) {
	function jnews_excerpt_length() {
		return 30;
	}
}

if ( ! function_exists( 'jnews_woo_content_width' ) ) {
	function jnews_woo_content_width() {
		$layout = jnews_can_render_woo_widget();

		switch ( $layout ) {
			case 'right-sidebar':
			case 'left-sidebar':
				return 8;
				break;

			case 'right-sidebar-narrow':
			case 'left-sidebar-narrow':
				return 9;
				break;

			case 'double-sidebar':
			case 'double-right-sidebar':
				return 6;
				break;
		}

		return 12;
	}
}

if ( ! function_exists( 'jnews_can_render_woo_widget' ) ) {
	function jnews_can_render_woo_widget() {
		if ( is_archive() ) {
			return get_theme_mod( 'jnews_woocommerce_archive_page_layout', 'right-sidebar' );
		}

		if ( is_single() ) {
			return get_theme_mod( 'jnews_woocommerce_single_page_layout', 'right-sidebar' );
		}

		return 'right-sidebar';
	}
}

if ( ! function_exists( 'jnews_get_woo_widget' ) ) {
	function jnews_get_woo_widget() {
		if ( is_archive() ) {
			return get_theme_mod( 'jnews_woocommerce_archive_sidebar', 'default-sidebar' );
		}

		if ( is_single() ) {
			return get_theme_mod( 'jnews_woocommerce_single_sidebar', 'default-sidebar' );
		}

		return 'default-sidebar';
	}
}

if ( ! function_exists( 'jnews_get_woo_second_widget' ) ) {
	function jnews_get_woo_second_widget() {
		if ( is_archive() ) {
			return get_theme_mod( 'jnews_woocommerce_archive_second_sidebar', 'default-sidebar' );
		}

		if ( is_single() ) {
			return get_theme_mod( 'jnews_woocommerce_single_second_sidebar', 'default-sidebar' );
		}

		return 'default-sidebar';
	}
}

if ( ! function_exists( 'jnews_get_woo_sticky_sidebar' ) ) {
	function jnews_get_woo_sticky_sidebar() {
		if ( is_archive() ) {
			if ( get_theme_mod( 'jnews_woocommerce_sticky_sidebar', true ) ) {
				return 'jeg_sticky_sidebar';
			}
		}

		if ( is_single() ) {
			if ( get_theme_mod( 'jnews_woocommerce_single_sticky_sidebar', true ) ) {
				return 'jeg_sticky_sidebar';
			}
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_get_woo_main_class' ) ) {
	function jnews_get_woo_main_class() {
		$layout = jnews_can_render_woo_widget();

		switch ( $layout ) {
			case 'left-sidebar':
				echo 'jeg_sidebar_left';
				break;

			case 'left-sidebar-narrow':
				echo 'jeg_sidebar_left jeg_wide_content';
				break;

			case 'right-sidebar-narrow':
				echo 'jeg_wide_content';
				break;

			case 'double-sidebar':
				echo 'jeg_double_sidebar';
				break;

			case 'double-right-sidebar':
				echo 'jeg_double_right_sidebar';
				break;

			default:
				break;
		}
	}
}

if ( ! function_exists( 'jnews_bbpress_content_width' ) ) {
	function jnews_bbpress_content_width() {
		$layout = jnews_get_bbpress_page_layout();

		switch ( $layout ) {
			case 'right-sidebar':
			case 'left-sidebar':
				return 8;
				break;

			case 'right-sidebar-narrow':
			case 'left-sidebar-narrow':
				return 9;
				break;

			case 'double-sidebar':
			case 'double-right-sidebar':
				return 6;
				break;
		}

		return 12;
	}
}

if ( ! function_exists( 'jnews_get_bbpress_main_class' ) ) {
	function jnews_get_bbpress_main_class() {
		$layout = jnews_get_bbpress_page_layout();

		switch ( $layout ) {
			case 'left-sidebar':
				echo 'jeg_sidebar_left';
				break;

			case 'left-sidebar-narrow':
				echo 'jeg_sidebar_left jeg_wide_content';
				break;

			case 'right-sidebar-narrow':
				echo 'jeg_wide_content';
				break;

			case 'double-sidebar':
				echo 'jeg_double_sidebar';
				break;

			case 'double-right-sidebar':
				echo 'jeg_double_right_sidebar';
				break;

			default:
				break;
		}
	}
}

if ( ! function_exists( 'jnews_get_bbpress_page_layout' ) ) {
	function jnews_get_bbpress_page_layout() {
		return get_theme_mod( 'jnews_bbpress_page_layout', 'right-sidebar' );
	}
}

if ( ! function_exists( 'jnews_bbpress_render_sidebar' ) ) {
	function jnews_bbpress_render_sidebar() {
		$layout = jnews_get_bbpress_page_layout();

		if ( $layout !== 'no-sidebar' ) {
			$jnews_bbpress_get_sticky_sidebar = jnews_bbpress_get_sticky_sidebar();
			$sidebar                          = array(
				'content-sidebar'  => get_theme_mod( 'jnews_bbpress_sidebar', 'default-sidebar' ),
				'is_sticky'        => $jnews_bbpress_get_sticky_sidebar,
				'sticky-sidebar'   => $jnews_bbpress_get_sticky_sidebar,
				'width-sidebar'    => jnews_bbpress_get_sidebar_width(),
				'position-sidebar' => 'left',
			);

			set_query_var( 'sidebar', $sidebar );
			get_template_part( 'fragment/archive-sidebar' );

			if ( $layout === 'double-right-sidebar' || $layout === 'double-sidebar' ) {
				$sidebar['content-sidebar']  = get_theme_mod( 'jnews_bbpress_second_sidebar', 'default-sidebar' );
				$sidebar['position-sidebar'] = 'right';
				set_query_var( 'sidebar', $sidebar );
				get_template_part( 'fragment/archive-sidebar' );
			}
		}
	}
}

if ( ! function_exists( 'jnews_bbpress_get_sticky_sidebar' ) ) {
	function jnews_bbpress_get_sticky_sidebar() {
		if ( get_theme_mod( 'jnews_bbpress_sticky_sidebar', true ) ) {
			return 'jeg_sticky_sidebar';
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_bbpress_get_sidebar_width' ) ) {
	function jnews_bbpress_get_sidebar_width() {
		$layout = jnews_get_bbpress_page_layout();

		if ( $layout === 'left-sidebar' || $layout === 'right-sidebar' ) {
			return 4;
		}

		return 3;
	}
}

if ( ! function_exists( 'jnews_get_woo_sidebar_width' ) ) {
	function jnews_get_woo_sidebar_width() {
		$layout = jnews_can_render_woo_widget();

		if ( $layout === 'left-sidebar' || $layout === 'right-sidebar' ) {
			return 4;
		}

		return 3;
	}
}

if ( ! function_exists( 'jnews_background_ads' ) ) {
	function jnews_background_ads() {
		$html = '';
		$url  = esc_url( get_theme_mod( 'jnews_background_ads_url' ) );

		if ( ! empty( $url ) ) {
			$new_tab = get_theme_mod( 'jnews_background_ads_open_tab', false ) ? '_blank' : '';
			$html    = "<div class=\"bgads\"><a href=\"$url\" target='{$new_tab}'></a></div>";
		}

		echo jnews_sanitize_output( $html );
	}
}

if ( ! function_exists( 'jnews_remove_protocol' ) ) {
	function jnews_remove_protocol( $url ) {
		$disallowed = array( 'http://', 'https://' );
		foreach ( $disallowed as $d ) {
			if ( strpos( $url, $d ) === 0 ) {
				return str_replace( $d, '//', $url );
			}
		}

		return $url;
	}
}


if ( ! function_exists( 'jnews_recursive_category' ) ) {
	function jnews_recursive_category( $categories, &$result ) {
		foreach ( $categories as $category ) {
			$result[] = $category;
			$children = get_categories( array( 'parent' => $category->term_id ) );

			if ( ! empty( $children ) ) {
				jnews_recursive_category( $children, $result );
			}
		}
	}
}

if ( ! function_exists( 'jnews_get_youtube_vimeo_id' ) ) {
	function jnews_get_youtube_vimeo_id( $video_url ) {
		$video_type = jnews_check_video_type( $video_url );
		$video_id   = '';

		if ( $video_type == 'youtube' ) {
			$regexes = array(
				'#(?:https?:)?//www\.youtube(?:\-nocookie|\.googleapis)?\.com/(?:v|e|embed)/([A-Za-z0-9\-_]+)#',
				// Comprehensive search for both iFrame and old school embeds
				'#(?:https?(?:a|vh?)?://)?(?:www\.)?youtube(?:\-nocookie)?\.com/watch\?.*v=([A-Za-z0-9\-_]+)#',
				// Any YouTube URL. After http(s) support a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#(?:https?(?:a|vh?)?://)?youtu\.be/([A-Za-z0-9\-_]+)#',
				// Any shortened youtu.be URL. After http(s) a or v for Youtube Lyte and v or vh for Smart Youtube plugin
				'#<div class="lyte" id="([A-Za-z0-9\-_]+)"#',
				// YouTube Lyte
				'#data-youtube-id="([A-Za-z0-9\-_]+)"#',
				// LazyYT.js
			);

			foreach ( $regexes as $regex ) {
				if ( preg_match( $regex, $video_url, $matches ) ) {
					$video_id = $matches[1];
				}
			}
		}

		if ( $video_type == 'vimeo' ) {
			$regexes = array(
				'#<object[^>]+>.+?http://vimeo\.com/moogaloop.swf\?clip_id=([A-Za-z0-9\-_]+)&.+?</object>#s',
				// Standard Vimeo embed code
				'#(?:https?:)?//player\.vimeo\.com/video/([0-9]+)#',
				// Vimeo iframe player
				'#\[vimeo id=([A-Za-z0-9\-_]+)]#',
				// JR_embed shortcode
				'#\[vimeo clip_id="([A-Za-z0-9\-_]+)"[^>]*]#',
				// Another shortcode
				'#\[vimeo video_id="([A-Za-z0-9\-_]+)"[^>]*]#',
				// Yet another shortcode
				'#(?:https?://)?(?:www\.)?vimeo\.com/([0-9]+)#',
				// Vimeo URL
				'#(?:https?://)?(?:www\.)?vimeo\.com/channels/(?:[A-Za-z0-9]+)/([0-9]+)#',
				// Channel URL
			);

			foreach ( $regexes as $regex ) {
				if ( preg_match( $regex, $video_url, $matches ) ) {
					$video_id = $matches[1];
				}
			}
		}

		if ( $video_type == 'dailymotion' ) {
			$regexes = array(
				'#<object[^>]+>.+?http://www\.dailymotion\.com/swf/video/([A-Za-z0-9]+).+?</object>#s',
				// Dailymotion flash
				'#//www\.dailymotion\.com/embed/video/([A-Za-z0-9]+)#',
				// Dailymotion iframe
				'#(?:https?://)?(?:www\.)?dailymotion\.com/video/([A-Za-z0-9]+)#',
				// Dailymotion URL
				'#(?:https?://)?(?:www\.)?dai\.ly/([A-Za-z0-9]+)#',
			);

			foreach ( $regexes as $regex ) {
				if ( preg_match( $regex, $video_url, $matches ) ) {
					$video_id = $matches[1];
				}
			}
		}

		return $video_id;
	}
}

/**
 * Generate header unique style
 */
if ( ! function_exists( 'jnews_header_styling' ) ) {
	function jnews_header_styling( $attr, $unique_class ) {
		$type  = isset( $attr['header_type'] ) ? $attr['header_type'] : 'heading_1';
		$style = '';

		switch ( $type ) {
			case 'heading_1':
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 .jeg_block_title span, .{$unique_class}.jeg_block_heading_1 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_1 { border-color: {$attr['header_line_color']}; }";
				}

				break;
			case 'heading_2':
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 .jeg_block_title span, .{$unique_class}.jeg_block_heading_2 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_secondary_background'] ) && ! empty( $attr['header_secondary_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_2 { background-color: {$attr['header_secondary_background']}; }";
				}

				break;
			case 'heading_3':
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_3 { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_3 .jeg_block_title span, .{$unique_class}.jeg_block_heading_3 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				break;
			case 'heading_4':
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_4 .jeg_block_title span { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_4 .jeg_block_title span, .{$unique_class}.jeg_block_heading_4 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				break;
			case 'heading_5':
				if ( isset( $attr['header_background'] ) && ! empty( $attr['header_background'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5 .jeg_block_title span, .{$unique_class}.jeg_block_heading_5 .jeg_subcat { background: {$attr['header_background']}; }";
				}

				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5 .jeg_block_title span, .{$unique_class}.jeg_block_heading_5 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_5:before { border-color: {$attr['header_line_color']}; }";
				}

				break;
			case 'heading_6':
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6 .jeg_block_title span, .{$unique_class}.jeg_block_heading_6 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6 { border-color: {$attr['header_line_color']}; }";
				}

				if ( isset( $attr['header_accent_color'] ) && ! empty( $attr['header_accent_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_6:after { background-color: {$attr['header_accent_color']}; }";
				}

				break;
			case 'heading_7':
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_7 .jeg_block_title span, .{$unique_class}.jeg_block_heading_7 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_accent_color'] ) && ! empty( $attr['header_accent_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_7 .jeg_block_title span { border-color: {$attr['header_accent_color']}; }";
				}

				break;
			case 'heading_8':
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_8 .jeg_block_title span, .{$unique_class}.jeg_block_heading_8 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}
				break;
			case 'heading_9':
				if ( isset( $attr['header_text_color'] ) && ! empty( $attr['header_text_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_9 .jeg_block_title span, .{$unique_class}.jeg_block_heading_9 .jeg_block_title i { color: {$attr['header_text_color']}; }";
				}

				if ( isset( $attr['header_line_color'] ) && ! empty( $attr['header_line_color'] ) ) {
					$style .= ".{$unique_class}.jeg_block_heading_9 { border-color: {$attr['header_line_color']}; }";
				}
				break;
		}

		return $style;
	}
}

if ( ! function_exists( 'jnews_module_custom_color' ) ) {
	function jnews_module_custom_color( $attr, $unique_class, $name = '' ) {
		$unique_class = trim( $unique_class );
		$style        = '';

		if ( isset( $attr['title_color'] ) && ! empty( $attr['title_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_title a { color: {$attr['title_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_title a, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a, .{$unique_class} .jeg_pl_md_card .jeg_post_category a:hover { color: {$attr['title_color']} }";
					break;
			}
		}

		if ( isset( $attr['accent_color'] ) && ! empty( $attr['accent_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_meta_author a, .{$unique_class} .jeg_pl_md_5 .jeg_post_title a:hover { color: {$attr['accent_color']} }";
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_readmore:hover { background-color: {$attr['accent_color']}; }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_meta_author a, .{$unique_class} .jeg_post_title a:hover { color: {$attr['accent_color']} }";
					$style .= ".{$unique_class} .jeg_readmore:hover { background-color: {$attr['accent_color']}; }";
					$style .= ".{$unique_class} .jeg_readmore:hover { border-color: {$attr['accent_color']}; }";
					break;
			}
		}

		if ( isset( $attr['readmore_background'] ) && ! empty( $attr['readmore_background'] ) ) {
			$style .= ".{$unique_class} .jeg_readmore { background-color: {$attr['readmore_background']}; }";
		}

		if ( isset( $attr['alt_color'] ) && ! empty( $attr['alt_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_meta, .{$unique_class} .jeg_pl_md_5 .jeg_post_meta .fa { color: {$attr['alt_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_meta, .{$unique_class} .jeg_post_meta .fa, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a:hover, .{$unique_class} .jeg_pl_md_card .jeg_post_category a, .{$unique_class}.jeg_postblock .jeg_subcat_list > li > a.current { color: {$attr['alt_color']} }";
					break;
			}
		}

		if ( isset( $attr['excerpt_color'] ) && ! empty( $attr['excerpt_color'] ) ) {
			switch ( $name ) {
				case '35':
				case '36':
					$style .= ".{$unique_class} .jeg_pl_md_5 .jeg_post_excerpt { color: {$attr['excerpt_color']} }";
					break;
				default:
					$style .= ".{$unique_class} .jeg_post_excerpt { color: {$attr['excerpt_color']} }";
					break;
			}
		}

		if ( isset( $attr['block_background'] ) && ! empty( $attr['block_background'] ) ) {
			switch ( $name ) {
				case '11':
				case '12':
					$style .= ".{$unique_class}.jeg_postblock .jeg_postblock_content, .{$unique_class}.jeg_postblock .jeg_inner_post { background: {$attr['block_background']} }";
					break;
				case '32':
				case '33':
				case '35':
				case '36':
				case '37':
					$style .= ".{$unique_class}.jeg_postblock .box_wrap { background-color: {$attr['block_background']} }";
					break;
				default:
					$style .= ".{$unique_class}.jeg_postblock .jeg_post { background-color: {$attr['block_background']} }";
					break;
			}
		}

		if ( isset( $attr['bg_color'] ) && ! empty( $attr['bg_color'] ) ) {
			$style .= ".{$unique_class}.jeg_postblock .jeg_postblock_content { background-color: {$attr['bg_color']} }";
		}

		return $style;
	}
}

if ( ! function_exists( 'jnews_customizer' ) ) {
	function jnews_customizer() {
		return Jeg\Customizer\Customizer::get_instance();
	}
}

/** Translate */

if ( ! function_exists( 'jnews_language_switcher' ) ) {
	function jnews_language_switcher() {
		if ( function_exists( 'pll_the_languages' ) ) {
			$parameter = apply_filters(
				'jnews_top_lang_param',
				array(
					'dropdown'               => 0,
					'echo'                   => 0,
					'hide_if_empty'          => 1,
					'menu'                   => 0,
					'show_flags'             => 1,
					'show_names'             => 1,
					'display_names_as'       => 'name',
					'force_home'             => 0,
					'hide_if_no_translation' => 0,
					'hide_current'           => 1,
					'post_id'                => null,
					'raw'                    => 0,
				)
			);

			echo "<ul class='jeg_nav_item jeg_top_lang_switcher'>" .
				pll_the_languages( $parameter ) .
				'</ul>';
		} elseif ( function_exists( 'icl_get_languages' ) ) {

			$languages = icl_get_languages( 'skip_missing=0&orderby=code' );

			if ( ! empty( $languages ) ) {
				$output = '';

				foreach ( $languages as $language ) {
					$output .= '<li class="avalang">
                                    <a href="' . esc_url( $language['url'] ) . '" data-tourl="false">
                                        <img src="' . esc_url( $language['country_flag_url'] ) . "\" title=\"{$language['native_name']}\" alt=\"{$language['code']}\" data-pin-no-hover=\"true\">
                                        <span>{$language['native_name']}</span>
                                    </a>
                                </li>";
				}

				echo "<ul class='jeg_top_lang_switcher'>{$output}</ul>";
			}
		}
	}
}


/** Print Translation */

if ( ! function_exists( 'jnews_print_translation' ) ) {
	function jnews_print_translation( $string, $domain, $name ) {
		do_action( 'jnews_print_translation', $string, $domain, $name );
	}
}

if ( ! function_exists( 'jnews_print_main_translation' ) ) {
	add_action( 'jnews_print_translation', 'jnews_print_main_translation', 10, 2 );

	function jnews_print_main_translation( $string, $domain ) {
		call_user_func_array( 'esc_html_e', array( $string, $domain ) );
	}
}

/** Return Translation */

if ( ! function_exists( 'jnews_return_translation' ) ) {
	function jnews_return_translation( $string, $domain, $name, $escape = true ) {
		return apply_filters( 'jnews_return_translation', $string, $domain, $name, $escape );
	}
}

if ( ! function_exists( 'jnews_return_main_translation' ) ) {
	add_filter( 'jnews_return_translation', 'jnews_return_main_translation', 10, 4 );

	function jnews_return_main_translation( $string, $domain, $name, $escape = true ) {
		if ( $escape ) {
			return call_user_func_array( 'esc_html__', array( $string, $domain ) );
		} else {
			return call_user_func_array( '__', array( $string, $domain ) );
		}
	}
}

if ( ! function_exists( 'jnews_the_author_link' ) ) {
	function jnews_the_author_link( $author = null, $print = true ) {
		if ( $print ) {
			printf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author ) ) ),
				get_the_author_meta( 'display_name', $author )
			);
		} else {
			return sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author ) ) ),
				get_the_author_meta( 'display_name', $author )
			);
		}
	}
}


if ( ! function_exists( 'jnews_get_respond_link' ) ) {
	function jnews_get_respond_link( $post_id = null ) {
		$permalink    = get_the_permalink( $post_id );
		$comment_type = get_theme_mod( 'jnews_comment_type', 'WordPress' );
		$suffix       = '';

		if ( $comment_type === 'WordPress' && is_user_logged_in() ) {
			$suffix = '#respond';
		} else {
			$suffix = '#comments';
		}

		if ( defined( 'JNEWS_AUTOLOAD_POST' ) ) {
			if ( ! jnews_get_option( 'autoload_disable_comment', false ) ) {
				$suffix = '';
			}
		}

		return $permalink . $suffix;
	}
}

/**
 * Edit Post
 */
if ( ! function_exists( 'jnews_edit_post' ) ) {
	function jnews_edit_post( $id, $position = 'left', $type = 'post' ) {
		if ( current_user_can( 'edit_posts' ) && ! defined( 'JNEWS_SANDBOX_URL' ) ) {
			$text = '';
			$url  = '#';
			switch ( $type ) {
				case 'post':
					$text = esc_html__( 'edit post', 'jnews' );
					$url  = get_edit_post_link( $id );
					break;
				case 'playlist':
					$text = esc_html__( 'edit playlist', 'jnews' );
					$url  = get_permalink( $id );
					break;
				case 'podcast':
					$text = esc_html__( 'edit podcast', 'jnews' );
					$url  = get_edit_term_link( $id );
					break;
				case 'category':
					$text = esc_html__( 'edit category', 'jnews' );
					$url  = get_edit_term_link( $id );
					break;
			}

			return "<a class=\"jnews-edit-post {$position}\" href=\"{$url}\" target=\"_blank\">
                        <i class=\"fa fa-pencil\"></i>
                        <span>{$text}</span>
                    </a>";
		}

		return false;
	}
}

/**
 * Menu Instance Shorthand
 */
if ( ! function_exists( 'jnews_menu' ) ) {
	function jnews_menu() {
		return JNews\Menu\Menu::getInstance();
	}
}

/**
 * Get Mobile Menu Content
 */
if ( ! function_exists( 'jnews_render_mobile_menu_content' ) ) {
	add_action( 'jnews_mobile_menu_cotent', 'jnews_render_mobile_menu_content' );

	function jnews_render_mobile_menu_content() {
		get_template_part( 'fragment/header/mobile-menu-content' );
	}
}

/**
 * Comment Number
 */
if ( ! function_exists( 'jnews_get_comments_number' ) ) {
	function jnews_get_comments_number( $post_id = 0 ) {
		$comment         = JNews\Comment\CommentNumber::getInstance();
		$comments_number = $comment->comments_number( $post_id );

		return apply_filters( 'jnews_get_comments_number', $comments_number, $post_id );
	}
}

if ( ! function_exists( 'jnews_meta_views' ) ) {
	function jnews_meta_views( $post_id = null, $range = null, $number_format = true ) {
		$total = apply_filters( 'jnews_get_total_fake_view', 0, $post_id );

		return jnews_number_format( $total );
	}
}

if ( ! function_exists( 'jnews_sanitize_by_pass' ) ) {
	function jnews_sanitize_by_pass( $value ) {
		return $value;
	}
}


if ( ! function_exists( 'jnews_create_button' ) ) {
	function jnews_create_button( $value ) {
		$button_class  = apply_filters( 'jnews_header_button_' . $value . '_class', '', $value );
		$button_icon   = get_theme_mod( 'jnews_header_button_' . $value . '_icon', 'fa fa-envelope' );
		$button_text   = get_theme_mod( 'jnews_header_button_' . $value . '_text', 'Your text' );
		$button_form   = get_theme_mod( 'jnews_header_button_' . $value . '_form', 'default' );
		$button_nfolow = get_theme_mod( 'jnews_header_button_' . $value . '_nofollow', false );
		$button_target = get_theme_mod( 'jnews_header_button_' . $value . '_target', '_blank' );
		$button_type   = get_theme_mod( 'jnews_header_button_' . $value . '_type', 'url' );

		if ( 'submit' === $button_type ) {
			if ( class_exists( 'JNews_Frontend_Endpoint' ) && method_exists( JNews_Frontend_Endpoint::getInstance(), 'get_editor_slug' ) ) {
				$button_link = JNews_Frontend_Endpoint::getInstance()->get_editor_slug();
			} else {
				$button_link = get_theme_mod( 'jnews_header_button_' . $value . '_link', '#' );
			}
		} elseif ( 'upload' === $button_type ) {
			if ( class_exists( 'JNews_Frontend_Endpoint' ) && method_exists( JNews_Frontend_Endpoint::getInstance(), 'get_editor_slug' ) && defined( 'JNEWS_VIDEO' ) ) {
				$button_link = \JNEWS_VIDEO\Frontend\Frontend_Video_Endpoint::getInstance()->get_upload_slug();
			} else {
				$button_link = get_theme_mod( 'jnews_header_button_' . $value . '_link', '#' );
			}
		} else {
			$button_link = get_theme_mod( 'jnews_header_button_' . $value . '_link', '#' );
		}

		?>
		<a href="<?php echo esc_attr( $button_link ); ?>"
			class="btn <?php echo esc_attr( $button_form ); ?> <?php echo esc_attr( $button_class ); ?>"
			target="<?php echo esc_attr( $button_target ); ?>"
			<?php echo( $button_nfolow ? 'rel="nofollow"' : '' ); ?>>
			<i class="<?php echo esc_attr( $button_icon ); ?>"></i>
			<?php echo esc_html( $button_text ); ?>
		</a>
		<?php
	}
}

if ( ! function_exists( 'jnews_can_render_header' ) ) {
	function jnews_can_render_header( $device, $row ) {
		$columns    = array();
		$can_render = false;

		if ( $device === 'desktop' || $device === 'desktop_sticky' ) {
			$columns = array( 'left', 'center', 'right' );
		}

		if ( $device === 'mobile' ) {
			if ( $row === 'top' ) {
				$columns = array( 'center' );
			} else {
				$columns = array( 'left', 'center', 'right' );
			}
		}

		foreach ( $columns as $column ) {
			if ( $device === 'desktop_sticky' ) {
				$device = 'sticky';
			}

			$setting_element = "jnews_hb_element_{$device}_{$row}_{$column}";
			$default_element = get_theme_mod( $setting_element, jnews_header_default( "{$device}_element_{$row}_{$column}" ) );

			if ( ! empty( $default_element ) && is_array( $default_element ) ) {
				$can_render = true;
				break;
			}
		}

		return $can_render;
	}
}

if ( ! function_exists( 'jnews_get_module_instance' ) ) {
	function jnews_get_module_instance( $name ) {
		do_action( 'jnews_build_shortcode_' . strtolower( $name ) );

		if ( method_exists( $name, 'getInstance' ) ) {
			return call_user_func( array( $name, 'getInstance' ) );
		}
		return null;
	}
}


if ( ! function_exists( 'jnews_rand_color' ) ) {
	function jnews_rand_color() {
		return '#' . str_pad( dechex( mt_rand( 0, 0xFFFFFF ) ), 6, '0', STR_PAD_LEFT );
	}
}

if ( ! function_exists( 'jnews_ago_time' ) ) {
	function jnews_ago_time( $time ) {
		return esc_html(
			sprintf(
				jnews_return_translation( '%s ago', 'jnews', 'sago' ),
				$time
			)
		);
	}
}

if ( ! function_exists( 'jnews_random_class' ) ) {
	function jnews_random_class() {
		return 'jnews' . '_' . uniqid();
	}
}

if ( ! function_exists( 'jnews_header_default' ) ) {
	function jnews_header_default( $option ) {
		$default = '';

		switch ( $option ) {

			/** DISPLAY */
			case 'desktop_display_top_left':
			case 'desktop_display_mid_right':
			case 'desktop_display_bottom_left':
			case 'sticky_display_mid_left':
			case 'mobile_display_mid_center':
				$default = 'grow';
				break;
			case 'desktop_display_top_center':
			case 'desktop_display_top_right':
			case 'desktop_display_mid_left':
			case 'desktop_display_mid_center':
			case 'desktop_display_bottom_center':
			case 'desktop_display_bottom_right':
			case 'sticky_display_mid_center':
			case 'sticky_display_mid_right':
			case 'mobile_display_mid_left':
			case 'mobile_display_mid_right':
				$default = 'normal';
				break;

			/** ELEMENT */
			case 'desktop_element_top_left':
				$default = array( 'top_bar_menu' );
				break;
			case 'desktop_element_top_right':
				$default = array();
				break;
			case 'desktop_element_mid_left':
			case 'mobile_element_mid_center':
				$default = array( 'logo' );
				break;
			case 'desktop_element_bottom_left':
			case 'sticky_element_mid_left':
				$default = array( 'main_menu' );
				break;
			case 'desktop_element_bottom_right':
			case 'sticky_element_mid_right':
			case 'mobile_element_mid_right':
				$default = array( 'search_icon' );
				break;
			case 'mobile_element_mid_left':
				$default = array( 'nav_icon' );
				break;
			case 'drawer_element_top':
				$default = array( 'search_form', 'mobile_menu' );
				break;
			case 'drawer_element_bottom':
				$default = array( 'social_icon', 'footer_copyright' );
				break;
		}

		return $default;
	}
}

if ( ! function_exists( 'jeg_get_author_name' ) ) {
	function jeg_get_author_name( $author_id = '' ) {
		return get_the_author_meta( 'display_name', $author_id );
	}
}

if ( ! function_exists( 'jeg_locate_template' ) ) {
	function jeg_locate_template( $template, $load = false, $args = array() ) {
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		if ( ( true == $load ) && ! empty( $template ) ) {
			include $template;
		}

		return $template;
	}
}

if ( ! function_exists( 'jeg_get_normal_widget_class_name_from_module' ) ) {
	function jeg_get_normal_widget_class_name_from_module( $name ) {
		$name = str_replace( 'JNews\Module\Widget\Widget_', '', $name );
		$name = str_replace( '_Option', '', $name );
		$name = str_replace( '_View', '', $name );

		return '\\JNews\\Widget\\Normal\\Element\\' . $name . 'Widget';
	}
}

if ( ! function_exists( 'jeg_theme_version_log' ) ) {
	add_action( 'switch_theme', 'jeg_theme_version_log' );

	function jeg_theme_version_log() {
		if ( is_admin() ) {
			$log_version     = get_option( 'jnews_theme_version_log' );
			$current_version = wp_get_theme( 'jnews' )->get( 'Version' );

			if ( ! empty( $log_version ) ) {
				if ( version_compare( $current_version, $log_version['current_version'], '>' ) ) {
					update_option(
						'jnews_theme_version_log',
						array(
							'current_version' => $current_version,
							'old_version'     => $log_version['current_version'],
						)
					);
				}
			} else {
				update_option(
					'jnews_theme_version_log',
					array(
						'current_version' => $current_version,
						'old_version'     => false,
					)
				);
			}
		}
	}
}

if ( ! function_exists( 'jeg_is_frontend_vc' ) ) {
	function jeg_is_frontend_vc() {
		return function_exists( 'vc_is_inline' ) && vc_is_inline();
	}
}


if ( ! function_exists( 'jeg_is_frontend_elementor' ) ) {
	function jeg_is_frontend_elementor() {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			return true;
		}
	}
}


if ( ! function_exists( 'jeg_get_post_date' ) ) {
	function jeg_get_post_date( $format = '', $post = null ) {
		$publish_date                = isset( $post->publish_date ) ? date( $format ?: 'Y-m-d', $post->publish_date ) : get_the_date( $format, $post );
		$modified_date               = isset( $post->update_date ) ? date( $format ?: 'Y-m-d', $post->update_date ) : get_the_modified_date( $format, $post );
		$publish_date_number_format  = isset( $post->publish_date ) ? date( 'Y-m-d', $post->publish_date ) : get_the_date( 'Y-m-d', $post );
		$modified_date_number_format = isset( $post->update_date ) ? date( 'Y-m-d', $post->update_date ) : get_the_modified_date( 'Y-m-d', $post );

		if ( get_theme_mod( 'jnews_global_post_date', 'modified' ) === 'publish' ) {
			return $publish_date;
		} elseif ( get_theme_mod( 'jnews_global_post_date', 'modified' ) === 'both' ) {
			if ( strtotime( $publish_date_number_format ) >= strtotime( $modified_date_number_format ) ) {
				return $publish_date;
			} else {
				return $publish_date . ' - ' . jnews_return_translation( 'Updated on', 'jnews', 'updated_on' ) . ' ' . $modified_date;
			}
		} elseif ( get_theme_mod( 'jnews_global_post_date', 'modified' ) === 'modified' ) {
			if ( strtotime( $publish_date_number_format ) >= strtotime( $modified_date_number_format ) ) {
				return $publish_date;
			} else {
				return $modified_date;
			}
		}

		return $publish_date;
	}
}

if ( ! function_exists( 'jeg_render_elementor_style' ) ) {
	function jeg_render_elementor_style( $post ) {
		if ( get_post_meta( $post->ID, '_elementor_edit_mode', true ) === 'builder' ) {
			$style = get_post_meta( $post->ID, '_elementor_page_settings', true );

			if ( ! empty( $style['custom_css'] ) ) {
				echo '<style type="text/css" data-type="elementor_custom-css">' . $style['custom_css'] . '</style>';
			}
		}
	}
}

if ( ! function_exists( 'jeg_render_builder_content' ) ) {
	function jeg_render_builder_content( $page_id ) {
		$is_built_with_elementor = false;
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			if ( jnews_constant_version_compare( 'ELEMENTOR_VERSION', '3.6.0', '>=' ) ) {
				$is_built_with_elementor = \Elementor\Plugin::$instance->documents->get( $page_id )->is_built_with_elementor();
			} else {
				$is_built_with_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor( $page_id );
			}
		}

		if ( $is_built_with_elementor ) {
			$frontend = \Elementor\Plugin::$instance->frontend;

			add_action( 'wp_enqueue_scripts', array( $frontend, 'enqueue_styles' ) );
			add_action( 'wp_head', array( $frontend, 'print_fonts_links' ) );
			add_action( 'wp_footer', array( $frontend, 'wp_footer' ) );

			if ( method_exists( $frontend, 'add_menu_in_admin_bar' ) ) {
				jnews_admin_topbar_menu( array( $frontend, 'add_menu_in_admin_bar' ), 200 );
			}

			add_action( 'wp_enqueue_scripts', array( $frontend, 'register_scripts' ), 5 );
			add_action( 'wp_enqueue_scripts', array( $frontend, 'register_styles' ), 5 );

			$html = $frontend->get_builder_content( $page_id );

			add_filter( 'get_the_excerpt', array( $frontend, 'start_excerpt_flag' ), 1 );
			add_filter( 'get_the_excerpt', array( $frontend, 'end_excerpt_flag' ), 20 );
		} else {
			$page = get_post( $page_id );
			$html = do_shortcode( $page->post_content );
		}

		return apply_filters( 'jeg_render_builder_content', $html, $page_id );
	}
}


if ( ! function_exists( 'jeg_generate_random_string' ) ) {
	function jeg_generate_random_string( $length = 10 ) {
		return substr( str_shuffle( str_repeat( $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil( $length / strlen( $x ) ) ) ), 1, $length );
	}
}


if ( ! function_exists( 'jeg_string_insert' ) ) {
	function jeg_string_insert( $str, $insert, $pos ) {
		$str = substr( $str, 0, $pos ) . $insert . substr( $str, $pos );

		return $str;
	}
}


if ( ! function_exists( 'jeg_add_class_search_widget' ) ) {
	if ( ! is_admin() ) {
		add_filter( 'dynamic_sidebar_params', 'jeg_add_class_search_widget' );
	}

	function jeg_add_class_search_widget( $params ) {
		if ( $params[0]['widget_name'] == 'Search' ) {
			$params[0] = array_replace( $params[0], array( 'before_widget' => str_replace( 'widget_search', 'widget_search jeg_search_wrapper', $params[0]['before_widget'] ) ) );
		}

		return $params;
	}
}


if ( ! function_exists( 'jeg_default_query_args' ) ) {
	add_filter( 'jnews_default_query_args', 'jeg_default_query_args' );

	function jeg_default_query_args( $args ) {
		if ( $args['post_type'] !== 'post' ) {
			unset( $args['category__in'] );
			unset( $args['category__not_in'] );
			unset( $args['tag__in'] );
			unset( $args['tag__not_in'] );
		}

		return $args;
	}
}

if ( ! function_exists( 'jnews_check_cookies_path' ) ) {

	function jnews_check_cookies_path( $option ) {

		if ( function_exists( 'jeg_check_cookies_path' ) ) {
			$option = jeg_check_cookies_path( $option );
		}

		return $option;
	}
}

if ( ! function_exists( 'jnews_unset_unnecessary_cpt' ) ) {

	add_filter( 'jnews_unset_unnecessary_attr', 'jnews_unset_unnecessary_cpt' );

	function jnews_unset_unnecessary_cpt( $data ) {

		$taxonomies = JNews\Util\Cache::get_enable_custom_taxonomies();
		$taxonomies = array_keys( $taxonomies );
		$data       = array_merge( $taxonomies, $data );

		return $data;
	}
}


if ( ! function_exists( 'jnews_default_query_cpt' ) ) {

	add_filter( 'jnews_default_query_args', 'jnews_default_query_cpt', 10, 2 );

	function jnews_default_query_cpt( $args, $attr ) {

		$taxonomies = JNews\Util\Cache::get_enable_custom_taxonomies();
		$taxonomies = array_keys( $taxonomies );

		foreach ( $taxonomies as $taxonomy ) {

			if ( ! empty( $attr[ $taxonomy ] ) ) {

				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => explode( ',', $attr[ $taxonomy ] ),
						'operator' => 'IN',
					),
				);
			}
		}

		return $args;
	}
}

if ( ! function_exists( 'jnews_archive_custom_get_posts' ) ) {

	if ( ! is_admin() ) {
		add_action( 'pre_get_posts', 'jnews_archive_custom_get_posts' );
	}

	function jnews_archive_custom_get_posts( $query ) {

		if ( $query->is_main_query() ) {

			if ( is_category() ) {
				if ( get_theme_mod( 'jnews_category_page_layout', 'right-sidebar' ) === 'custom-template' ) {
					$query->query_vars['posts_per_page'] = (int) get_theme_mod( 'jnews_category_custom_template_number_post', 10 );
				}
			} elseif ( is_author() ) {
				if ( get_theme_mod( 'jnews_author_page_layout', 'right-sidebar' ) === 'custom-template' ) {
					$query->query_vars['posts_per_page'] = (int) get_theme_mod( 'jnews_author_custom_template_number_post', 10 );
				}
			} elseif ( is_archive() ) {
				if ( get_theme_mod( 'jnews_archive_page_layout', 'right-sidebar' ) === 'custom-template' ) {
					$query->query_vars['posts_per_page'] = (int) get_theme_mod( 'jnews_archive_custom_template_number_post', 10 );
				}
			}
		}
	}
}

if ( ! function_exists( 'jeg_find_author' ) ) {

	add_action( 'wp_ajax_jeg_find_author', 'jeg_find_author' );

	function jeg_find_author() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_author' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$users = new \WP_User_Query(
				array(
					'search'         => "*{$query}*",
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
						'user_url',
					),
				)
			);

			$users_found = $users->get_results();

			$result = array();

			if ( count( $users_found ) > 0 ) {
				foreach ( $users_found as $user ) {
					$result[] = array(
						'value' => $user->ID,
						'text'  => $user->display_name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_find_post' ) ) {

	add_action( 'wp_ajax_jeg_find_post', 'jeg_find_post' );

	function jeg_find_post() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_post' ) ) {

			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			if ( (bool) $query ) {
				add_filter(
					'posts_where',
					function ( $where ) use ( $query ) {
						global $wpdb;
						$where .= $wpdb->prepare( "AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like( $query ) . '%' );
						return $where;
					}
				);
			}

			$query = new \WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title(),
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_find_category' ) ) {

	add_action( 'wp_ajax_jeg_find_category', 'jeg_find_category' );

	function jeg_find_category() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_category' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'category' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => 0,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
				'number'     => 50,
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_find_review' ) ) {

	add_action( 'wp_ajax_jeg_find_review', 'jeg_find_review' );

	function jeg_find_review() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_review' ) ) {

			$query = new \WP_Query(
				array(
					'post_type'      => 'post',
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title(),
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_find_tag' ) ) {

	add_action( 'wp_ajax_jeg_find_tag', 'jeg_find_tag' );

	function jeg_find_tag() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_tag' ) ) {
			$query = sanitize_text_field( wp_unslash( $_REQUEST['query'] ) );

			$args = array(
				'taxonomy'   => array( 'post_tag' ),
				'orderby'    => 'id',
				'order'      => 'ASC',
				'hide_empty' => true,
				'fields'     => 'all',
				'name__like' => urldecode( $query ),
			);

			$terms = get_terms( $args );

			$result = array();

			if ( count( $terms ) > 0 ) {
				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}

			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_get_category_option' ) ) {
	function jeg_get_category_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'category' );

		if ( (int) $count <= jnews_load_resource_limit() ) {
			$terms = get_categories( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name,
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_categories(
					array(
						'hide_empty'   => false,
						'hierarchical' => true,
						'include'      => $selected,
					)
				);

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}
		}

		return $result;
	}
}


if ( ! function_exists( 'jeg_get_tag_option' ) ) {
	function jeg_get_tag_option( $value = null ) {
		$result = array();
		$count  = wp_count_terms( 'post_tag' );

		if ( (int) $count <= jnews_load_resource_limit() ) {
			$terms = get_tags( array( 'hide_empty' => 0 ) );
			foreach ( $terms as $term ) {
				$result[] = array(
					'value' => $term->term_id,
					'text'  => $term->name,
				);
			}
		} else {
			$selected = $value;

			if ( ! empty( $selected ) ) {
				$terms = get_tags(
					array(
						'hide_empty'   => false,
						'hierarchical' => true,
						'include'      => $selected,
					)
				);

				foreach ( $terms as $term ) {
					$result[] = array(
						'value' => $term->term_id,
						'text'  => $term->name,
					);
				}
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'jeg_get_author_option' ) ) {
	function jeg_get_author_option( $value = null ) {
		$result  = array();
		$options = array_flip( jnews_get_all_author() );

		if ( empty( $options ) ) {
			$values = explode( ',', $value );
			foreach ( $values as $val ) {
				if ( ! empty( $val ) ) {
					$user     = get_userdata( $val );
					$result[] = array(
						'value' => $val,
						'text'  => $user->display_name,
					);
				}
			}
		} else {
			foreach ( $options as $key => $label ) {
				$result[] = array(
					'value' => $key,
					'text'  => $label,
				);
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'jeg_get_post_option' ) ) {
	function jeg_get_post_option( $value = null ) {
		$result = array();

		if ( ! empty( $value ) ) {
			$values = explode( ',', $value );

			foreach ( $values as $val ) {
				$result[] = array(
					'value' => $val,
					'text'  => get_the_title( $val ),
				);
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'jeg_get_review_option' ) ) {
	function jeg_get_review_option( $value = null ) {
		$result = array();

		if ( ! empty( $value ) ) {
			$values = explode( ',', $value );

			foreach ( $values as $val ) {
				$result[] = array(
					'value' => $val,
					'text'  => get_the_title( $val ),
				);
			}
		}

		return $result;
	}
}

add_action( 'wp_ajax_jeg_get_category_option', 'jeg_get_ajax_category_option' );
add_action( 'wp_ajax_jeg_get_author_option', 'jeg_get_ajax_author_option' );
add_action( 'wp_ajax_jeg_get_tag_option', 'jeg_get_ajax_tag_option' );
add_action( 'wp_ajax_jeg_get_post_option', 'jeg_get_ajax_post_option' );
add_action( 'wp_ajax_jeg_get_review_option', 'jeg_get_ajax_review_option' );

function jeg_get_ajax_category_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_category' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( jeg_get_category_option( $value ) );
	}
}

function jeg_get_ajax_author_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_author' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( jeg_get_author_option( $value ) );
	}
}

function jeg_get_ajax_tag_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_tag' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( jeg_get_tag_option( $value ) );
	}
}

function jeg_get_ajax_post_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_post' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( jeg_get_post_option( $value ) );
	}
}

function jeg_get_ajax_review_option() {
	if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_review' ) ) {
		$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
		wp_send_json_success( jeg_get_review_option( $value ) );
	}
}

if ( ! function_exists( 'vp_option' ) ) {
	function vp_option() {
		return false;
	}
}

add_action(
	'jeg_after_inline_dynamic_css',
	function () {
		$nothumbnail = get_theme_mod( 'jnews_image_placeholder', false );

		if ( ! $nothumbnail ) {
			echo '<style type="text/css">
					.no_thumbnail .jeg_thumb,
					.thumbnail-container.no_thumbnail {
					    display: none !important;
					}
					.jeg_search_result .jeg_pl_xs_3.no_thumbnail .jeg_postblock_content,
					.jeg_sidefeed .jeg_pl_xs_3.no_thumbnail .jeg_postblock_content,
					.jeg_pl_sm.no_thumbnail .jeg_postblock_content {
					    margin-left: 0;
					}
					.jeg_postblock_11 .no_thumbnail .jeg_postblock_content,
					.jeg_postblock_12 .no_thumbnail .jeg_postblock_content,
					.jeg_postblock_12.jeg_col_3o3 .no_thumbnail .jeg_postblock_content  {
					    margin-top: 0;
					}
					.jeg_postblock_15 .jeg_pl_md_box.no_thumbnail .jeg_postblock_content,
					.jeg_postblock_19 .jeg_pl_md_box.no_thumbnail .jeg_postblock_content,
					.jeg_postblock_24 .jeg_pl_md_box.no_thumbnail .jeg_postblock_content,
					.jeg_sidefeed .jeg_pl_md_box .jeg_postblock_content {
					    position: relative;
					}
					.jeg_postblock_carousel_2 .no_thumbnail .jeg_post_title a,
					.jeg_postblock_carousel_2 .no_thumbnail .jeg_post_title a:hover,
					.jeg_postblock_carousel_2 .no_thumbnail .jeg_post_meta .fa {
					    color: #212121 !important;
					} 
					.jnews-dark-mode .jeg_postblock_carousel_2 .no_thumbnail .jeg_post_title a,
					.jnews-dark-mode .jeg_postblock_carousel_2 .no_thumbnail .jeg_post_title a:hover,
					.jnews-dark-mode .jeg_postblock_carousel_2 .no_thumbnail .jeg_post_meta .fa {
					    color: #fff !important;
					} 
				</style>';
		}
	}
);

if ( ! function_exists( 'jeg_video_duration' ) ) {
	/**
	 * Get YouTube Duration
	 *
	 * @param $duration
	 *
	 * @return false|string
	 */
	function jeg_video_duration( $duration ) {
		if ( ! empty( $duration ) ) {
			preg_match( '/(\d+)H/', $duration, $match );
			$h = count( $match ) ? filter_var( $match[0], FILTER_SANITIZE_NUMBER_INT ) : 0;

			preg_match( '/(\d+)M/', $duration, $match );
			$m = count( $match ) ? filter_var( $match[0], FILTER_SANITIZE_NUMBER_INT ) : 0;

			preg_match( '/(\d+)S/', $duration, $match );
			$s = count( $match ) ? filter_var( $match[0], FILTER_SANITIZE_NUMBER_INT ) : 0;

			$time_in_second = 0 === $h && 0 === $m && 0 === $s ? intval( $duration ) : intval( $h * 3600 + $m * 60 + $s );

			$duration = gmdate( 'H:i:s', $time_in_second );
		}

		return $duration;
	}
}

if ( ! function_exists( 'jnews_reset_license_server' ) ) {
	/**
	 * Reset license handler on server
	 */
	function jnews_reset_license_server() {
		$license = jnews_get_license();
		$args    = array(
			'method'    => 'POST',
			'sslverify' => false,
			'body'      => build_query( array( 'code' => $license['purchase_code'] ) ),
		);

		$response = wp_remote_post( jnews_get_license_server_rest_url( 'resetLicense' ), $args );
		$response = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( $response ) {
			jnews_reset_license();
		}
	}
}

if ( ! function_exists( 'jnews_reset_license' ) ) {
	/**
	 * Reset license handler on client
	 */
	function jnews_reset_license() {
		update_option( jnews_get_license_optionname(), array() );
	}
}

if ( ! function_exists( 'jnews_get_license' ) ) {
	/**
	 * Get license data
	 */
	function jnews_get_license() {
		return get_option( jnews_get_license_optionname(), array() );
	}
}

if ( ! function_exists( 'jnews_get_license_optionname' ) ) {
	/**
	 * Get license option name
	 *
	 * @return string
	 */
	function jnews_get_license_optionname() {
		return 'jnews_license';
	}
}

if ( ! function_exists( 'jnews_get_data_server_rest_url' ) ) {
	/**
	 * Get data server rest URL
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	function jnews_get_data_server_rest_url( $path ) {
		$namespace = '/wp-json/jnews-server/v1/';
		return esc_url( JNEWS_THEME_SERVER . $namespace . $path );
	}
}

if ( ! function_exists( 'jnews_get_license_server_rest_url' ) ) {
	/**
	 * Get license server rest URL
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	function jnews_get_license_server_rest_url( $path ) {
		$namespace = '/wp-json/jeg-license/v1/';
		return esc_url( JEGTHEME_SERVER . $namespace . $path );
	}
}

if ( ! function_exists( 'jnews_get_domain' ) ) {
	/**
	 * @param string $url
	 *
	 * @return string
	 */
	function jnews_get_domain( $url ) {
		$original_domain = parse_url( $url );
		if ( $original_domain ) {
			$original_domain = $original_domain['host'];
			$subdomains      = $original_domain;
			$domain          = $original_domain;

			if ( preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $matches ) ) {
				$domain = $matches['domain'];
			}

			$subdomains = strstr( $subdomains, $domain, true );
			$domain     = str_replace( $subdomains, '', $original_domain );
			return $domain;
		}
		return $original_domain;
	}
}

/**
 * ----- DARK MODE FUNCTION ----- *
 * */
if ( ! function_exists( 'jeg_dark_mode' ) ) {
	function jeg_dark_mode( $classes ) {
		$dm_options = get_theme_mod( 'jnews_dark_mode_options', 'jeg_toggle_light' );

		// add option class
		if ( $dm_options === 'jeg_timed_dark' ) {
			$classes[] = 'jeg_timed_dark';
		} elseif ( $dm_options === 'jeg_full_dark' ) {
			$classes[] = 'jeg_full_dark';
		} elseif ( $dm_options === 'jeg_toggle_light' ) {
			$classes[] = 'jeg_toggle_light';
		} elseif ( $dm_options === 'jeg_device_dark' ) {
			$classes[] = 'jeg_device_dark';
		} elseif ( $dm_options === 'jeg_toggle_dark' ) {
			$classes[] = 'jeg_toggle_dark';
		} elseif ( $dm_options === 'jeg_device_toggle' ) {
			$classes[] = 'jeg_device_toggle';
		}

		if ( ( $dm_options === 'jeg_device_dark' || $dm_options === 'jeg_device_toggle' ) && ! isset( $_COOKIE['darkmode'] ) ) {
			$classes[] = 'jnews-dark-nocookie';
		}

		// add dark mode class
		if ( $dm_options === 'jeg_full_dark' || ( ! isset( $_COOKIE['darkmode'] ) && $dm_options === 'jeg_toggle_dark' ) ) {
			$classes[] = 'jnews-dark-mode';
		} elseif ( $dm_options === 'jeg_toggle_light' || $dm_options === 'jeg_timed_dark' || $dm_options === 'jeg_device_dark' || $dm_options === 'jeg_toggle_dark' || $dm_options === 'jeg_device_toggle' ) {
			if ( isset( $_COOKIE['darkmode'] ) && $_COOKIE['darkmode'] === 'false' ) {
				if ( in_array( 'jnews-dark-mode', $classes ) ) {
					unset( $classes[ array_search( 'jnews-dark-mode', $classes ) ] );
				}
			} elseif ( isset( $_COOKIE['darkmode'] ) && $_COOKIE['darkmode'] === 'true' ) {
				$classes[] = 'jnews-dark-mode';
			}
		} elseif ( in_array( 'jnews-dark-mode', $classes ) ) {
				unset( $classes[ array_search( 'jnews-dark-mode', $classes ) ] );
		}

		if ( is_customize_preview() ) {
			$classes[] = 'jeg_dark_preview';
		}

		return $classes;
	}

	add_filter( 'body_class', 'jeg_dark_mode' );
}

/** Start Zoom Button */
if ( ! function_exists( 'jnews_show_zoom_button' ) ) {
	/**
	 * @return bool|mixed
	 */
	function jnews_show_zoom_button() {
		$flag = false;
		if ( is_single() && 'post' === get_post_type() ) {
			if ( vp_metabox( 'jnews_single_post.override_template' ) ) {
				$flag = vp_metabox( 'jnews_single_post.override.0.show_zoom_button' );
			} else {
				$flag = get_theme_mod( 'jnews_single_zoom_button', false );
			}
		}

		return apply_filters( 'jnews_show_zoom_button', $flag );
	}
}
/** End Zoom button */

/** Start Coauthor function */
if ( ! function_exists( 'jnews_check_coauthor_plus' ) ) {
	/**
	 * Check plugin coauthor plus
	 *
	 * @return bool
	 */
	function jnews_check_coauthor_plus() {
		return class_exists( 'CoAuthors_Plus' ) && function_exists( 'coauthors_posts_links' );
	}
}
if ( ! function_exists( 'jnews_check_number_authors' ) ) {
	/**
	 * Check number of authors
	 *
	 * @param null $post_id
	 *
	 * @return int|string|void
	 */
	function jnews_check_number_authors( $post_id = null ) {
		if ( jnews_check_coauthor_plus() ) {
			/** Get coauhtor list */
			$coauthors = get_coauthors( $post_id );
			if ( ! empty( $coauthors ) ) {
				return count( $coauthors );
			}
		}

		return '';
	}
}

if ( ! function_exists( 'jnews_get_author_coauthor' ) ) {
	/**
	 * Get author with coauthor
	 *
	 * @param null $post_id
	 * @param bool $image
	 * @param null $by_class
	 *
	 * @return string
	 */
	function jnews_get_author_coauthor( $post_id = null, $image = true, $by_class = null, $limit = 0 ) {
		if ( jnews_check_coauthor_plus() ) {
			/** Get coauhtor list */
			$coauthors = get_coauthors( $post_id );
			/** Real Iterate */
			$real_i = new CoAuthorsIterator( $post_id );
			/** Custom Iterate */
			$fake_i = new CoAuthorsIterator( $post_id );

			/** Start iterate */
			$real_i->iterate();
			$fake_i->iterate();

			/** Check limiter iterate */
			$count          = $fake_i->count();
			$check_limit    = ( $limit > 0 && $count > $limit ) ? true : false;
			$residual       = ( $check_limit ) ? $count - $limit : 0;
			$residual       = ( $check_limit ) ? '<span class="meta_text separators">' . $residual . ' ' . jnews_return_translation( 'others', 'jnews', 'others' ) . '</span>' : '';
			$fake_i->count  = ( $check_limit ) ? $limit + 1 : $count;
			$is_multiple    = $fake_i->count() > 1 ? true : false;
			$multiple_class = $is_multiple ? 'jnews_multiple_author' : '';

			$authors      = '';
			$author_image = '';

			/** Loop coauthor */
			foreach ( $coauthors as $coauthor ) {
				/** Trigger real iterate */
				$real_i->iterate();
				$output       = '';
				$author_text  = '';
				$guest_author = ( 'guest-author' === $coauthor->type ) ? true : false;

				/** Check author avatar */
				if ( $image && $real_i->position < 3 ) {
					if ( $guest_author ) {
						$author_image .= coauthors_get_avatar( $coauthor, 80, null, $coauthor->display_name, $multiple_class );
					} else {
						$author_image .= get_avatar( get_the_author_meta( 'ID', $coauthor->ID ), 80, null, get_the_author_meta( 'display_name', $coauthor->ID ), array( 'class' => $multiple_class ) );
					}
					if ( ! $is_multiple ) {
						$author_text .= $author_image;
						$author_image = '';
					}
				}

				/** Continue if limit reacehed */
				if ( $check_limit && $fake_i->is_last() ) {
					continue;
				}
				if ( 0 === $fake_i->position ) {
					$author_text .= '<span class="meta_text ' . $by_class . '">' . jnews_return_translation( 'by', 'jnews', 'by' ) . '</span>';
				}
				$author_text .= $guest_author ? coauthors_posts_links_single( $coauthor ) : jnews_the_author_link( $coauthor->ID, false );

				// Append separators.
				if ( 1 === $fake_i->count() - $fake_i->position ) { // last author or only author.
					$output .= $author_text;
				} elseif ( 2 === $fake_i->count() - $fake_i->position ) { // second to last.
					$output .= $author_text . '<span class="meta_text separators-and">' . jnews_return_translation( 'and', 'jnews', 'and' ) . '</span>';
				} else {
					$output .= $author_text . '<span class="meta_text separators">' . jnews_return_translation( ',', 'jnews', ',' ) . '</span>';
				}

				/** Trigger custom iterate */
				$fake_i->iterate();
				$authors .= $output;
			}
			$authors  = $is_multiple ? $author_image . $authors : $authors;
			$authors .= $residual;

			return $authors;
		}

		return '';
	}
}
/** END Coauhtor function */

/** Subscribe Function */
add_action( 'wp_ajax_jnews_get_subscribe_count', 'jnews_ajax_get_subscribe_count' );
if ( ! function_exists( 'jnews_ajax_get_subscribe_count' ) ) {
	function jnews_ajax_get_subscribe_count() {
		if ( isset( $_POST['uid'] ) ) {
			$user_id = $_POST['uid'];
			/** @var  $follow_count */
			$follow_count = function_exists( 'bp_follow_total_follow_counts' ) ? bp_follow_total_follow_counts( array( 'user_id' => $user_id ) ) : 0;

			/** @var  $subscribe_wrapper */
			$subscriber = '<span class="jeg_subscribe_count">' . $follow_count['followers'] . ' ' . jnews_return_translation( 'Subscriber', 'jnews', 'subscriber' ) . '</span>';
			wp_send_json(
				array(
					'status'  => 1,
					'content' => $subscriber,
				)
			);
		} else {
			wp_send_json(
				array(
					'status' => 0,
				)
			);
		}
	}
}
/** END Subscribe Function */

/** START New Instagram Scraper */
if ( ! function_exists( 'jnews_get_instagram_data' ) ) {
	/**
	 * JNews Instagram scraper.
	 * This scraper can be use for unlimited data Instagram media ( Auto load scroll data ) without API
	 * but still need investigation for Auto load scroll data
	 *
	 * @param $username
	 * @param null     $type
	 * @param null     $data
	 * @param null     $formated_data
	 * @param null     $position
	 * @param null     $cache
	 *
	 * @return array|string|WP_Error
	 * @since 6.0.2
	 */
	function jnews_get_instagram_data( $username, $type = null, $data = null, $formated_data = null, $position = null, $cache = null ) {
		$client = array(
			'base_url' => 'https://www.instagram.com',
			'headers'  => array(
				'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
				'Origin'     => 'https://www.instagram.com',
				'Referer'    => 'https://www.instagram.com',
				'Connection' => 'close',
			),
			'cookies'  => array(
				'ig_or'      => 'landscape-primary',
				'ig_pr'      => '1',
				'ig_vh'      => 1080,
				'ig_vw'      => 1920,
				'ds_user_id' => 25025320,
			),
		);
		switch ( $type ) {
			case 'user':
				$search_response = wp_remote_get(
					'https://www.instagram.com/' . $username . '/feed',
					// 'https://www.instagram.com/' . $username . '/?__a=1',
					array(
						'timeout' => 10,
					)
				);

				if ( wp_remote_retrieve_response_message( $search_response ) ) {
					$pattern = '@<script type="text/javascript">window._sharedData = (.*);</script>@';
					preg_match_all( $pattern, $search_response['body'], $matches );
					if ( ! empty( $matches[1][0] ) ) {
						$search_response = json_decode( $matches[1][0], true );
						$users           = isset( $search_response['entry_data']['ProfilePage'][0]['graphql']['user'] ) ? $search_response['entry_data']['ProfilePage'][0]['graphql']['user'] : null;
						return array(
							'id'         => isset( $users['id'] ) ? $users['id'] : null,
							'username'   => isset( $users['username'] ) ? $users['username'] : null,
							'counts'     => array(
								'followed_by' => isset( $users['edge_followed_by']['count'] ) ? $users['edge_followed_by']['count'] : null,
							),
							'is_private' => isset( $users['is_private'] ) ? $users['is_private'] : null,
							'response'   => array(
								'code' => '200',
							),
						);
					}
				}

				return '';
			case 'search':
				$params          = array(
					'path' => '/v1/users/' . $username,
				);
				$query           = http_build_query( $params, null, '&' );
				$search_response = wp_remote_get(
					'https://api.instacloud.io/?' . $query,
					array(
						'timeout' => 10,
					)
				);
				if ( ! is_wp_error( $search_response ) ) {
					$search_response = json_decode( $search_response['body'], true );
					if ( null !== $search_response ) {
						$meta = isset( $search_response['meta'] ) ? $search_response['meta'] : array();
						if ( ! empty( $meta ) && 200 === $meta['code'] ) {
							$users = $search_response['data'];

							return array(
								'id'       => $users['id'],
								'username' => $users['username'],
								'counts'   => $users['counts'],
								'response' => array(
									'code' => $meta['code'],
								),
							);
						}
					}
				}

				return '';
			case 'request':
				$temp_data = $data;
				unset( $temp_data['query_hash'] );
				$data_json       = wp_json_encode( $temp_data );
				$gis             = md5( $data_json );
				$params          = array(
					'query_hash' => $data['query_hash'],
					'variables'  => $data_json,
				);
				$query           = http_build_query( $params, null, '&' );
				$args            = array(
					'timeout' => 10,
					'headers' => $client['headers'],
					'cookies' => array(),
				);
				$args['headers'] = array_merge(
					$args['headers'],
					array(
						'X-Requested-With' => 'XMLHttpRequest',
						'X-Instagram-Ajax' => '1',
						'X-Instagram-Gis'  => $gis,
					)
				);

				foreach ( $client['cookies'] as $cookie_name => $cookie_value ) {
					$cookie            = new WP_Http_Cookie( $cookie_name );
					$cookie->name      = $cookie_name;
					$cookie->value     = $cookie_value;
					$args['cookies'][] = $cookie;
				}

				$response = wp_remote_get( $client['base_url'] . '/graphql/query/?' . $query, $args );

				return $response;
			default:
				$user = jnews_get_instagram_data( $username, 'user' );

				if ( is_array( $user ) && isset( $user['is_private'] ) && $user['is_private'] ) {
					if ( current_user_can( 'administrator' ) ) {
						return sprintf( esc_html__( '%s Account is Private. This warning will only show if you login as Admin.', 'jnews' ), $username );
					}

					return array();
				}
				if ( is_string( $user ) ) {
					if ( current_user_can( 'administrator' ) ) {
						return esc_html__( 'The site cannot connect to Instagram. Please contact the Sever Administrator. This warning will only show if you login as Admin.', 'jnews' );
					}

					return array();
				}
				$args = array(
					'id'         => $user['id'],
					'first'      => 50,
					'query_hash' => 'f2405b236d85e8296cf30347c9f08c2a',
				);

				return jnews_get_instagram_data( $username, 'request', $args, null, null, $cache );
		}
	}
}
/** END New Instagram Fetcher */

/** START Twitch Counter */

if ( ! function_exists( 'jnews_get_twitch_data' ) ) {
	function jnews_get_twitch_data( $name ) {
		$twitch_token = get_option( 'jnews_option[jnews_twitch]', array() );
		if ( is_array( $twitch_token ) && ! empty( $twitch_token ) && time() < $twitch_token['expire'] ) {
			$search_response = wp_remote_get(
				"https://api.twitch.tv/helix/search/channels?query={$name}",
				array(
					'headers' => array(
						'Authorization' => "Bearer {$twitch_token['token']}",
						'client-id'     => get_theme_mod( 'jnews_twitch_client_id' ),
					),
				)
			);

			if ( ! is_wp_error( $search_response ) ) {
				$search_response = json_decode( $search_response['body'] );
				foreach ( $search_response->data as $data ) {
					if ( $data->broadcaster_login === $name ) {
						$search_response = wp_remote_get(
							"https://api.twitch.tv/helix/users/follows?to_id={$data->id}",
							array(
								'headers' => array(
									'Authorization' => "Bearer {$twitch_token['token']}",
									'client-id'     => get_theme_mod( 'jnews_twitch_client_id' ),
								),
							)
						);

						if ( ! is_wp_error( $search_response ) ) {
							$search_response = json_decode( $search_response['body'] );
							return $search_response->total;
						}
						break;
					}
				}
			}
			return false;
		}
	}
}

/** END Twitch Counter */

/** START Custom TGMPA */
if ( ! function_exists( 'jnews_tgmpa' ) ) {
	/**
	 * Helper function to register a collection of required plugins.
	 * Rewrite from TGM Plugin Activation
	 *
	 * @param array $plugins An array of plugin arrays.
	 * @param array $config Optional. An array of configuration values.
	 *
	 * @since 7.0.0
	 * @api
	 */
	function jnews_tgmpa( $plugins, $config = array() ) {
		$instance = call_user_func( array( get_class( $GLOBALS['jnews_tgmpa'] ), 'get_instance' ) );

		foreach ( $plugins as $plugin ) {
			call_user_func( array( $instance, 'register' ), $plugin );
		}

		if ( ! empty( $config ) && is_array( $config ) ) {
			// Send out notices for deprecated arguments passed.
			if ( isset( $config['notices'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.2.0', 'The `notices` config parameter was renamed to `has_notices` in TGMPA 2.2.0. Please adjust your configuration.' );
				if ( ! isset( $config['has_notices'] ) ) {
					$config['has_notices'] = $config['notices'];
				}
			}

			if ( isset( $config['parent_menu_slug'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.4.0', 'The `parent_menu_slug` config parameter was removed in TGMPA 2.4.0. In TGMPA 2.5.0 an alternative was (re-)introduced. Please adjust your configuration. For more information visit the website: http://tgmpluginactivation.com/configuration/#h-configuration-options.' );
			}
			if ( isset( $config['parent_url_slug'] ) ) {
				_deprecated_argument( __FUNCTION__, '2.4.0', 'The `parent_url_slug` config parameter was removed in TGMPA 2.4.0. In TGMPA 2.5.0 an alternative was (re-)introduced. Please adjust your configuration. For more information visit the website: http://tgmpluginactivation.com/configuration/#h-configuration-options.' );
			}

			call_user_func( array( $instance, 'config' ), $config );
		}
	}
}

if ( ! function_exists( 'load_jnews_plugin_activation' ) ) {
	/**
	 * Ensure only one instance of the class is ever invoked.
	 *
	 * @since 2.5.0
	 */
	function load_jnews_plugin_activation() {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
		if ( $revert_dashboard ) {
				require_once get_parent_theme_file_path( 'tgm/class-jnews-plugin-activation.php' );
				require_once get_parent_theme_file_path( 'tgm/class-tgm-plugin-activation.php' );

				$GLOBALS['jnews_tgmpa'] = JNews_Plugin_Activation::get_instance();
		}
	}
}
/** END Custom TGMPA */

/** START Set Author */
if ( ! function_exists( 'set_author_query' ) ) {
	/**
	 * Helper function to set is_author class variable.
	 *
	 * @since 7.1.9
	 *
	 * @param WP_Query $query passed by parse_query action hook.
	 */
	function set_author_query( $query ) {
		$query->is_author = true;
		remove_action( 'parse_query', 'set_author_query' );
	}
}
/** END Set Author */

/** Start JNews metabox classes */
if ( ! function_exists( 'jnews_metabox_classes' ) ) {
	/**
	 * Metabox Classes
	 *
	 * @param  mixed $classes
	 * @return void
	 */
	function jnews_metabox_classes( $classes ) {
		if ( ! ( function_exists( strtolower( 'JNews' ) . jnews_custom_text( 'evitca_si_' ) ) && call_user_func( array( call_user_func( strtolower( 'JNews' ) . jnews_custom_text( 'evitca_si_' ) ), 'is_' . jnews_custom_text( '_esnecil' ) . jnews_custom_text( 'detadilav' ) ) ) ) ) {
			$classes[] = jnews_custom_text( 'dekcol' );
			$classes[] = jnews_custom_text( 'desolc' );
		}

		return $classes;
	}
}
/** End JNews metabox classes */

/** Start custom template directory */
if ( ! function_exists( 'jnews_get_template_part' ) ) {
	/**
	 * @param $slug
	 * @param null $name
	 * @param bool $dir
	 */
	function jnews_get_template_part( $slug, $name = null, $dir = false ) {
		do_action( "jnews_get_template_part_{$slug}", $slug, $name, $dir );
		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
		if ( ! $dir ) {
			$dir = get_template_directory();
		}
		jnews_get_template_path( $templates, true, false, $dir );
	}
}

if ( ! function_exists( 'jnews_get_template_path' ) ) {
	/**
	 * @param $template_names
	 * @param bool           $load
	 * @param bool           $require_once
	 *
	 * @param string         $dir
	 *
	 * @return string
	 */
	function jnews_get_template_path( $template_names, $load = false, $require_once = true, $dir = false ) {
		$located = '';
		if ( $dir ) {
			foreach ( (array) $template_names as $template_name ) {
				if ( ! $template_name ) {
					continue;
				}
				/* search file within the $dir only */
				if ( file_exists( $dir . $template_name ) ) {
					$located = $dir . $template_name;
					break;
				}
			}
			if ( $load && '' !== $located ) {
				load_template( $located, $require_once );
			}
		}

		return $located;
	}
}
/** End custom template directory */

/** Start JNews check active */
if ( ! function_exists( 'jnews_is_active' ) ) {
	/**
	 * JNews checker
	 *
	 * @return JNews\Util\ValidateLicense
	 */
	function jnews_is_active() {
		return JNews\Util\ValidateLicense::getInstance();
	}
}
/** End JNews check active */

/** Start JNews log*/
if ( ! function_exists( 'jnews_log' ) ) {
	/**
	 * @param null $object
	 *
	 * Logging Variable/Object in php_error_log file
	 * Note : Use this for variable/object that cannot be printed to a html page
	 */
	function jnews_log( $object = null ) {
		if ( apply_filters( 'jnews_log', false ) ) {
			$contents = array(
				'caller' => array(
					'function' => '',
					'class'    => '',
					'line'     => '',
				),
			);
			ob_start(); // start buffer capture.
			if ( apply_filters( 'jnews_log_caller', false ) ) {
				$dbt                            = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
				$contents['caller']['function'] = isset( $dbt[1]['function'] ) ? $dbt[1]['function'] : '';
				$contents['caller']['class']    = isset( $dbt[1]['class'] ) ? $dbt[1]['class'] : '';
				$contents['caller']['line']     = isset( $dbt[1]['line'] ) ? $dbt[1]['line'] : '';
				print_r( $contents ); // dump the values.
			}
			print_r( $object ); // dump the values.
			$contents = ob_get_contents(); // put the buffer into a variable.
			ob_end_clean(); // end capture.
			error_log( $contents ); // log contents of the result of var_dump( $object ).
		}
	}
}
/** End JNews log*/

if ( ! function_exists( 'jnews_get_author_social' ) ) {
	function jnews_get_author_social() {
		return array(
			'website'    => 'fa-globe',
			'url'        => 'fa-globe',
			'facebook'   => 'fa-facebook-official',
			'tiktok'     => 'jeg-icon icon-tiktok',
			'twitter'    => 'fa-twitter',
			'linkedin'   => 'fa-linkedin',
			'pinterest'  => 'fa-pinterest',
			'behance'    => 'fa-behance',
			'github'     => 'fa-github',
			'flickr'     => 'fa-flickr',
			'tumblr'     => 'fa-tumblr',
			'dribbble'   => 'fa-dribbble',
			'soundcloud' => 'fa-soundcloud',
			'instagram'  => 'fa-instagram',
			'vimeo'      => 'fa-vimeo',
			'youtube'    => 'fa-youtube-play',
			'vk'         => 'fa-vk',
			'reddit'     => 'fa-reddit',
			'weibo'      => 'fa-weibo',
			'rss'        => 'fa-rss',
			'twitch'     => 'fa-twitch',
		);
	}
}


/**
 * Start permission function
 */
if ( ! function_exists( 'jnews_permission_manage_options' ) ) {
	/**
	 * Returns whether the current user has the specified capability.
	 *
	 * @return bool
	 */
	function jnews_permission_manage_options() {
		return current_user_can( 'manage_options' );
	}
}
/**
 * End permission function
 */

/**
 * Start constant version compare
 */
if ( ! function_exists( 'jnews_deprecated_version' ) ) {
	/**
	 * Compares two "PHP-standardized" version number strings
	 *
	 * @param string $name Constant string instead version string.
	 * @param string $version Second version number.
	 * @param string $operator
	 *
	 * @return int|bool
	 */
	function jnews_constant_version_compare( $name, $version, $operator ) {
		if ( defined( $name ) ) {
			return version_compare( constant( $name ), $version, $operator );
		}
		return false;
	}
}
/**
 * End constant version compare
 */

/**
 * Custom word count for other language support.
 * substitute for str_word_count
 *
 * @param $str
 * @return int
 */
function jnews_count_words( $str ) {
	$OUT   = 0;
	$IN    = 1;
	$state = $OUT;
	$wc    = 0; // word count
	$i     = 0;

	// Scan all characters one by one
	while ( $i < strlen( $str ) ) {
		// If next character is
		// a separator, set the
		// state as OUT
		if ( $str[ $i ] == ' ' ||
			$str[ $i ] == "\n" ||
			$str[ $i ] == "\t" ) {
			$state = $OUT;
		}

		// If next character is not a
		// word separator and state is
		// OUT, then set the state as
		// IN and increment word count
		elseif ( $state == $OUT ) {
			$state = $IN;
			++$wc;
		}

		// Move to next character
		++$i;
	}

	return $wc;
}

/* START Fix Bootstrap JS and Meta Header Issue with WordPress Download Manager Plugin */
if ( in_array( 'download-manager/download-manager.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( is_admin() && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wpdmpro' ) {
		add_action( 'admin_enqueue_scripts', 'deregister_bootstrap_script_jnews_essential', 100 );
		function deregister_bootstrap_script_jnews_essential() {
			wp_deregister_script( 'bootstrap' );
		}
	}
	if ( isset( $_GET['template_preview'] ) ) {
		remove_action( 'wp_head', array( JNews_Meta_Header::getInstance(), 'generate_social_meta' ), 1 );
	}
}
/* END Fix Bootstrap JS and Meta Header Issue with WordPress Download Manager Plugin */


if ( ! function_exists( 'get_svg' ) ) {
	/**
	 * @param null $object
	 *
	 * Logging Variable/Object in php_error_log file
	 * Note : Use this for variable/object that cannot be printed to a html page
	 */
	function jnews_get_svg( $icon ) {
		switch ( $icon ) {
			case 'tiktok':
				return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>';
			case 'discord':
				return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/></svg>';
			case 'twitter':
				return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>';
			case 'line':
				return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M311 196.8v81.3c0 2.1-1.6 3.7-3.7 3.7h-13c-1.3 0-2.4-.7-3-1.5l-37.3-50.3v48.2c0 2.1-1.6 3.7-3.7 3.7h-13c-2.1 0-3.7-1.6-3.7-3.7V196.9c0-2.1 1.6-3.7 3.7-3.7h12.9c1.1 0 2.4 .6 3 1.6l37.3 50.3V196.9c0-2.1 1.6-3.7 3.7-3.7h13c2.1-.1 3.8 1.6 3.8 3.5zm-93.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 2.1 1.6 3.7 3.7 3.7h13c2.1 0 3.7-1.6 3.7-3.7V196.8c0-1.9-1.6-3.7-3.7-3.7zm-31.4 68.1H150.3V196.8c0-2.1-1.6-3.7-3.7-3.7h-13c-2.1 0-3.7 1.6-3.7 3.7v81.3c0 1 .3 1.8 1 2.5c.7 .6 1.5 1 2.5 1h52.2c2.1 0 3.7-1.6 3.7-3.7v-13c0-1.9-1.6-3.7-3.5-3.7zm193.7-68.1H327.3c-1.9 0-3.7 1.6-3.7 3.7v81.3c0 1.9 1.6 3.7 3.7 3.7h52.2c2.1 0 3.7-1.6 3.7-3.7V265c0-2.1-1.6-3.7-3.7-3.7H344V247.7h35.5c2.1 0 3.7-1.6 3.7-3.7V230.9c0-2.1-1.6-3.7-3.7-3.7H344V213.5h35.5c2.1 0 3.7-1.6 3.7-3.7v-13c-.1-1.9-1.7-3.7-3.7-3.7zM512 93.4V419.4c-.1 51.2-42.1 92.7-93.4 92.6H92.6C41.4 511.9-.1 469.8 0 418.6V92.6C.1 41.4 42.2-.1 93.4 0H419.4c51.2 .1 92.7 42.1 92.6 93.4zM441.6 233.5c0-83.4-83.7-151.3-186.4-151.3s-186.4 67.9-186.4 151.3c0 74.7 66.3 137.4 155.9 149.3c21.8 4.7 19.3 12.7 14.4 42.1c-.8 4.7-3.8 18.4 16.1 10.1s107.3-63.2 146.5-108.2c27-29.7 39.9-59.8 39.9-93.1z"/></svg>';
			break;

		}
		return false;
	}
}