<?php
/**
 * @author : Jegtheme
 */

namespace JNews;

use JNews\Customizer\AdsOption;
use JNews\Customizer\ArchiveOption;
use JNews\Customizer\BlockOption;
use JNews\Customizer\CategoryOption;
use JNews\Customizer\CodeOption;
use JNews\Customizer\FontOption;
use JNews\Customizer\FooterOption;
use JNews\Customizer\HeaderOption;
use JNews\Customizer\ImageOption;
use JNews\Customizer\LayoutOption;
use JNews\Customizer\OtherOption;
use JNews\Customizer\SchemeStyleOption;
use JNews\Customizer\SearchOption;
use JNews\Customizer\SingleOption;
use JNews\Customizer\SocialOption;
use JNews\Walker\CategoryWalker;

/**
 * Class Theme JNews Customizer
 */
class Customizer {
	/**
	 * @var Customizer
	 */
	private static $instance;

	/**
	 * Package name
	 *
	 * @var string
	 */
	private static $package = 'JNews';

	/**
	 * @var Customizer
	 */
	private $customizer = null;

	/**
	 * Section of Customizer
	 */
	private $list_section = array(
		'jnews_ads_amp_section',
		'jnews_autoload_section',
		'jnews_frontend_submit_section',
		'jnews_preview_slider_section',
		'jnews_preview_slider_ads_section',
		'jnews_instagram_feed_section',
		'jnews_schema_setting',
		'jnews_main_schema',
		'jnews_article_schema',
		'jnews_like_section',
		'jnews_social_meta_section',
		'jnews_paywall_section',
		'jnews_podcast_general',
		'jnews_podcast_template',
		'jnews_podcast_category_template',
		'jnews_podcast_powerpress',
		'jnews_push_notification_section',
		'jnews_review_section',
		'jnews_social_login_section',
		'jnews_social_like_section',
		'jnews_select_share_section',
		'jnews_tiktok_feed_section',
		'jnews_video_buddypress',
		'jnews_video_single_post',
		'jnews_video_single_playlist',
		'jnews_video_archive_history',
		'jnews_global_weather_section',
		'jnews_header_weather_section',
	);

	/**
	 * @return Customizer
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Construct
	 */
	private function __construct() {
		// Need to load Customizer early for this kind of request.
		if ( isset( $_REQUEST['action'] ) && 'jnews_customizer_disable_panel' === $_REQUEST['action'] ) {
			$this->customizer = jnews_customizer();
		}

		if ( is_customize_preview() || ! is_admin() ) {
			add_action( 'customize_preview_init', array( $this, 'preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_control_js' ) );
			if ( defined( 'JNEWS_ESSENTIAL' ) ) {
				add_filter( 'jeg_register_lazy_section', array( $this, 'register_lazy_section' ) );
				add_filter( 'jeg_customizer_get_lazy_options', array( $this, 'prepare_lazy_option' ) );

				add_action( 'jeg_register_customizer_option', array( $this, 'load_customizer' ), 91 );

				add_filter( 'jeg_font_typography', array( $this, 'load_custom_font' ), 80 );
				add_filter( 'jeg_font_typography', array( $this, 'load_typekit' ), 81 );
				add_filter( 'jeg_generate_inline_style', array( $this, 'custom_font_css' ) );
				add_filter( 'jeg_not_google_font', array( $this, 'exclude_font' ) );
				add_filter( 'jeg_fonts_option_setting', array( $this, 'font_option_setting' ) );

				add_filter( 'jeg_register_lazy_section', array( $this, 'register_lazy_category' ) );
				add_filter( 'jeg_customizer_add_section', array( $this, 'prepare_add_section' ) );
				add_filter( 'jeg_customizer_add_field', array( $this, 'prepare_add_section' ) );
			}
		}

		if ( is_blog_admin() && defined( 'JNEWS_ESSENTIAL' ) && ! \JNews\Gutenberg::is_classic() ) {
			add_filter( 'jeg_fonts_option_setting', array( $this, 'font_option_setting' ) );
			add_filter( 'jeg_register_lazy_section', array( $this, 'register_lazy_section' ) );
		}

		jnews_admin_topbar_menu( array( $this, 'admin_bar' ), 40 );
	}

	public function prepare_lazy_option( $options ) {
		if ( is_array( $options ) ) {
			foreach ( $options as &$option ) {
				if ( isset( $option['type'] ) ) {
					$option['type'] = str_replace( 'jnews-', 'jeg-', $option['type'] );
				}
			}
		}

		return $options;
	}

	public function prepare_add_section( $section ) {
		if ( in_array( $section['id'], $this->list_section, true ) ) {
			if ( ! ( function_exists( strtolower( self::$package ) . jnews_custom_text( 'evitca_si_' ) ) && call_user_func( array( call_user_func( strtolower( self::$package ) . jnews_custom_text( 'evitca_si_' ) ), 'is_' . jnews_custom_text( '_esnecil' ) . jnews_custom_text( 'detadilav' ) ) ) ) ) {
				$section['type'] = 'jnews-link-section';
				$section['url']  = jnews_custom_text( 'esnecil-etavitca' );
			}
		}

		if ( isset( $section['type'] ) ) {
			$section['type'] = str_replace( 'jnews-', 'jeg-', $section['type'] );
		}

		return $section;
	}

	public function register_lazy_category( $result ) {
		if ( apply_filters( 'jnews_load_detail_customizer_category', false ) ) {
			$categories = get_categories(
				array(
					'hide_empty'   => false,
					'hierarchical' => true,
				)
			);

			$walker = new CategoryWalker();
			$walker->walk( $categories, 3 );

			foreach ( $walker->cache as $category ) {
				$section_id  = CategoryOption::get_section_id( $category );
				$category_id = $category->term_id;

				$result[ $section_id ][] = array(
					'function'  => array( $this, 'category_builder' ),
					'parameter' => array( $category_id ),
				);
			}
		}

		return $result;
	}

	public function category_builder( $category_id ) {
		include_once JNEWS_THEME_CLASSPATH . 'Customizer/sections/single_category.php';

		return single_category_option( $category_id );
	}


	public function register_lazy_section( $result ) {
		$array = array(
			'global_layout',
			'global_sidefeed',
			'global_color',
			'global_browser',
			'global_post_date',
			'global_cpt',
			'global_speed',
			'header_builder',
			'header_desktop_option',
			'header_desktop_sticky',
			'header_mobile_option',
			'header_social_icon',
			'header_date',
			'header_button',
			'header_vertical_menu',
			'header_html',
			'header_language',
			'header_nav_icon',
			'header_cart_detail',
			'header_cart_icon',
			'header_login',
			'header_search_icon',
			'header_search_form',
			'header_main_menu',
			'header_top_bar_menu',
			'header_logo',
			'header_drawer_container',
			'header_dark_mode',
			'footer_layout',
			'footer_global',
			'single_breadcrumb',
			'single_post',
			'single_related',
			'single_comment',
			'single_mobile_truncate',
			'single_video_following',
			'image_global',
			'image_library',
			'image_popup',
			'image_gif',
			'social_icon',
			'search_option',
			'search_live',
			'archive_index',
			'archive_global',
			'archive_search',
			'archive_author',
			'archive_attachment',
			'archive_notfound',
			'archive_woocommerce',
			'archive_bbpress',
			'font_global',
			'font_google',
			'font_additional',
			'font_typekit',
			'global_loader',
			'global_gdpr',
			'global_query',
			'global_gutenberg_editor', //eMAHmTKT
			'global_analytic',
			'global_api',
			'block',
			'category_global',
			'ads_header',
			'ads_article',
			'ads_archive',
			'ads_sidefeed',
			'ads_global',
			'ads_mobile',
			'scheme_style',
		);

		$path = JNEWS_THEME_CLASSPATH . 'Customizer/sections/';

		foreach ( $array as $id ) {
			$result[ "jnews_{$id}_section" ][] = "{$path}{$id}.php";
		}

		return $result;
	}

	public function font_option_setting() {
		return array(
			'jnews_body_font',
			'jnews_header_font',
			'jnews_main_menu_font',
			'jnews_block_heading_font',
			'jnews_h1_font',
			'jnews_p_font',
			'jnews_header_logo_text_font',
			'jnews_sticky_logo_text_font',
			'jnews_mobile_logo_text_font',
			'jnews_other_font',
		);
	}

	public function preview_init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_script' ), 99 );
	}

	public function customize_control_js() {
		wp_enqueue_style( 'jnews-additional-customizer', get_parent_theme_file_uri( 'assets/css/admin/additional-customizer.css' ) );

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jnews-extend-control', get_parent_theme_file_uri( 'assets/js/admin/extend-control.js' ), array( 'jquery' ), null, true );
	}

	public function load_script() {
		wp_enqueue_style( 'jnews-customizer-redirect', get_parent_theme_file_uri( 'assets/css/admin/theme-customizer.css' ) );
		wp_enqueue_style( 'vex', get_parent_theme_file_uri( 'assets/css/admin/vex.css' ) );

		wp_enqueue_script( 'vex', get_parent_theme_file_uri( 'assets/js/admin/vex.combined.min.js' ), array( 'jquery' ), null, true );
		wp_enqueue_script(
			'jnews-partial-refresh',
			get_parent_theme_file_uri( 'assets/js/admin/partial.refresh.js' ),
			array(
				'jquery',
				'customize-preview',
			),
			null,
			true
		);
		wp_enqueue_script( 'jnews-post-message', get_parent_theme_file_uri( 'assets/js/admin/post.message.js' ), array( 'jquery' ), null, true );
	}

	public function load_customizer() {
		$this->customizer = jnews_customizer();

		new LayoutOption( $this->customizer, 171 );
		new HeaderOption( $this->customizer, 172 );
		new FooterOption( $this->customizer, 173 );
		new SingleOption( $this->customizer, 174 );
		new ImageOption( $this->customizer, 175 );
		new SocialOption( $this->customizer, 176 );
		new SearchOption( $this->customizer, 177 );
		new CategoryOption( $this->customizer, 180 );
		new ArchiveOption( $this->customizer, 185 );
		new FontOption( $this->customizer, 191 );
		new OtherOption( $this->customizer, 192 );
		new AdsOption( $this->customizer, 193 );
		new BlockOption( $this->customizer, 193 );
		new CodeOption( $this->customizer, 195 );
		new SchemeStyleOption( $this->customizer, 199 );
	}

	public function exclude_font( $output ) {
		$excluded_font = array();
		$output        = is_array( $output ) ? $output : array();

		// type kit
		$typekit_font = get_theme_mod( 'jnews_type_kit', array() );
		if ( is_array( $typekit_font ) ) {
			foreach ( $typekit_font as $font ) {
				$excluded_font[] = $font['font_name'];
			}
		}

		$upload_font = get_theme_mod( 'jnews_additional_font', array() );
		if ( is_array( $upload_font ) ) {
			foreach ( $upload_font as $font ) {
				$excluded_font[] = $font['font_name'];
			}
		}

		$excluded_font           = array_merge( $excluded_font, array( 'Georgia', 'Helvetica', 'Monaco' ) );
		$output['excluded_font'] = $excluded_font;

		return $output;
	}

	public function load_typekit( $fonts ) {
		$custom_fonts = get_theme_mod( 'jnews_type_kit', array() );

		if ( ! empty( $custom_fonts ) ) {
			$custom_fonts_final = array();

			foreach ( $custom_fonts as $font ) {
				$custom_fonts_final[] = array(
					'family'      => $font['font_name'],
					'label'       => $font['font_name'],
					'subsets'     => array(),
					'is_standard' => true,
					'variants'    => array(),
					'type'        => 'typekit',
				);
			}

			$merged = array_merge( $custom_fonts_final, $fonts );

			return $merged;
		} else {
			return $fonts;
		}
	}

	public function load_custom_font( $fonts ) {
		$custom_fonts = get_theme_mod( 'jnews_additional_font', array() );

		if ( ! empty( $custom_fonts ) ) {
			$custom_fonts_final = array();
			$variants           = array();

			foreach ( $custom_fonts as $font ) {
				$variants[ $font['font_name'] ][] = array(
					'id'    => $font['font_weight'] . $font['font_style'],
					'label' => $font['font_weight'] . ' - ' . ucfirst( $font['font_style'] ),
				);
			}

			foreach ( $variants as $font => $variant ) {
				$custom_fonts_final[] = array(
					'family'      => $font,
					'label'       => $font,
					'subsets'     => array(),
					'is_standard' => true,
					'variants'    => $variant,
					'type'        => 'custom',
				);
			}

			$merged = array_merge( $custom_fonts_final, $fonts );

			return $merged;
		} else {
			return $fonts;
		}
	}

	public function custom_font_css( $generated_style ) {
		$custom_font_style = '';
		$custom_fonts      = get_theme_mod( 'jnews_additional_font', array() );

		foreach ( $custom_fonts as $font ) {
			if ( ! empty( $font['font_name'] ) ) {
				$font_src = array();

				if ( ! empty( $font['eot'] ) ) {
					$font_src[] = "url('" . wp_get_attachment_url( $font['eot'] ) . "#iefix') format('embedded-opentype')";
				}

				if ( ! empty( $font['woff'] ) ) {
					$font_src[] = "url('" . wp_get_attachment_url( $font['woff'] ) . "') format('woff')";
				}

				if ( ! empty( $font['ttf'] ) ) {
					$font_src[] = "url('" . wp_get_attachment_url( $font['ttf'] ) . "') format('truetype')";
				}

				if ( ! empty( $font['eot'] ) ) {
					$font_src[] = "url('" . wp_get_attachment_url( $font['svg'] ) . "') format('svg')";
				}

				$src                = 'src: ' . implode( ',', $font_src ) . ' ;';
				$custom_font_style .= " @font-face { font-family: '" . $font['font_name'] . "'; " . $src . " font-weight: {$font['font_weight']}; font-style: {$font['font_style']}; } ";
			}
		}

		return $custom_font_style . $generated_style;
	}

	public function admin_bar( $admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$admin_bar->add_menu(
			array(
				'id'    => 'jnews',
				'title' => '<span class="ab-icon"></span>JNews',
				'href'  => admin_url( 'admin.php?page=' . 'jnews' ),
			)
		);

		$submenus = $this->get_submenus();

		foreach ( $submenus as $menu ) {
			$admin_bar->add_menu(
				array(
					'parent' => $menu['parent'],
					'id'     => $menu['id'],
					'title'  => $menu['title'],
					'href'   => $menu['href'],
				)
			);
		}
	}

	protected function get_submenus() {
		$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
		$admin_url        = defined( 'JNEWS_ESSENTIAL' ) ? 'admin.php' : 'themes.php';

		$admin_page_url     = 'admin.php?page=';
		$customize_page_url = 'customize.php?autofocus';
		$get_permalink      = get_permalink();

		$label = array(
			array(
				'id'     => 'jnews_dashboard',
				'parent' => 'jnews',
				'title'  => esc_html__( 'Dashboard', 'jnews' ),
				'href'   => $revert_dashboard ? admin_url( $admin_page_url . 'jnews' ) : admin_url( $admin_url . '?page=jnews' ),
			),
			array(
				'id'     => 'jnews_import',
				'parent' => 'jnews',
				'title'  => esc_html__( 'Import Demo & Style', 'jnews' ),
				'href'   => $revert_dashboard ? admin_url( $admin_page_url . 'jnews_import' ) : admin_url( $admin_url . '?page=jnews&tab=jnews_import' ),
			),
			array(
				'id'     => 'jnews_plugin',
				'parent' => 'jnews',
				'title'  => esc_html__( 'Install Plugin', 'jnews' ),
				'href'   => $revert_dashboard ? admin_url( $admin_page_url . 'jnews_plugin' ) : admin_url( $admin_url . '?page=jnews&tab=jnews_plugin' ),
			),
			array(
				'id'     => 'jnews_customize',
				'parent' => 'jnews',
				'title'  => esc_html__( 'Customize Style', 'jnews' ),
				'href'   => admin_url( 'customize.php?url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_system',
				'parent' => 'jnews',
				'title'  => esc_html__( 'System Status', 'jnews' ),
				'href'   => $revert_dashboard ? admin_url( $admin_page_url . 'jnews_system' ) : admin_url( $admin_url . '?page=jnews&tab=jnews_system' ),
			),
			array(
				'id'     => 'jnews_documentation',
				'parent' => 'jnews',
				'title'  => esc_html__( 'Video Documentation', 'jnews' ),
				'href'   => $revert_dashboard ? admin_url( $admin_page_url . 'jnews_documentation' ) : admin_url( $admin_url . '?page=jnews&tab=jnews_documentation' ),
			),
			array(
				'id'     => 'jnews_customize_layout',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-magic"></i> ' . esc_html__( 'Layout, Color & Scheme', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_layout_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_header',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-list-alt"></i> ' . esc_html__( 'Header Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_header&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_footer',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-th-list"></i> ' . esc_html__( 'Footer Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_footer&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_single_post',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-newspaper-o"></i> ' . esc_html__( 'Single Post Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_single_post_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_image',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-picture-o"></i> ' . esc_html__( 'Image & Gallery Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_image_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_social',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-share-alt"></i> ' . esc_html__( 'Social, Like & View', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_social_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_search',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-search"></i> ' . esc_html__( 'Search Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_search_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_category',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-briefcase"></i> ' . esc_html__( 'Category Template', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_category_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_other_template',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-archive"></i> ' . esc_html__( 'Other Template', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_archive&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_font',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-font"></i> ' . esc_html__( 'Font Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_font&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_addtional',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-cogs"></i> ' . esc_html__( 'Additional Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_global_panel&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_ads',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-usd"></i> ' . esc_html__( 'Advertisement Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[panel]=jnews_ads&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_block',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-files-o"></i> ' . esc_html__( 'Global Block Option', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[section]=jnews_block_section&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_css',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-code"></i> ' . esc_html__( 'Additional CSS', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[section]=custom_css&url=' . $get_permalink ),
			),
			array(
				'id'     => 'jnews_customize_script',
				'parent' => 'jnews_customize',
				'title'  => '<i class="fa fa-code"></i> ' . esc_html__( 'Additional JavaScript', 'jnews' ),
				'href'   => admin_url( $customize_page_url . '[section]=jnews_code_section&url=' . $get_permalink ),
			),
		);

		return $label;
	}

}
