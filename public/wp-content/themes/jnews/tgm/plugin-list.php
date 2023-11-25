<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme JNews for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
if ( $revert_dashboard ) {
	require_once get_parent_theme_file_path( 'tgm/class-tgm-plugin-activation.php' );
	add_action( 'jnews_tgmpa_register', 'jnews_register_required_plugins' );
	add_filter( 'jnews_plugin_list', 'jnews_plugin_list' );

	function jnews_plugin_group() {
		$groups = array(
			'recommend'             => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Recommended Plugin', 'jnews' ),
				'items' => array(
					array(
						'name'               => esc_html__( 'HubSpot - CRM & Marketing', 'jnews' ),
						'slug'               => 'leadin',
						'recommended'        => true,
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'recommend',
						'description'        => esc_html__( 'HubSpot is a platform with all the tools and integrations you need for marketing, sales, and customer service.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/hubspot.png',
						),
					),
				),
			),
			'require'               => array(
				'type'   => 'required',
				'title'  => esc_html__( 'Required Plugin', 'jnews' ),
				'notice' => esc_html__( 'Please install all required plugin', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - Essential', 'jnews' ),
						'slug'             => 'jnews-essential',
						'version'          => '11.0.7',
						'source'           => 'jnews-essential.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'require',
						'description'      => esc_html__( 'Advertisement, Shortcode & Widget for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-customizer-category.png',
						),
						'flag'             => 'jnews',
					),
					array(
						'name'               => esc_html__( 'Vafpress Post Formats UI', 'jnews' ),
						'slug'               => 'vafpress-post-formats-ui-develop',
						'version'            => '1.5.3',
						'source'             => 'vafpress-post-formats-ui-develop.zip',
						'required'           => true,
						'force_activation'   => false,
						'force_deactivation' => false,
						'group'              => 'require',
						'description'        => esc_html__( 'Custom post format admin UI', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/vafpress.png',
						),
					),
				),
			),
			'builder'               => array(
				'type'   => 'required',
				'title'  => esc_html__( 'Page & Footer Builder', 'jnews' ),
				'notice' => esc_html__( 'Please only install and activate one of the plugins below', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'WPBakery Page Builder', 'jnews' ),
						'slug'               => 'js_composer',
						'version'            => '7.0',
						'source'             => 'js_composer.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'builder',
						'description'        => esc_html__( 'Drag and drop page builder for WordPress. Take full control over your WordPress site, build any layout you can imagine  &dash; no programming knowledge required.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/vc.png',
						),
					),
					array(
						'name'               => esc_html__( 'Elementor Page Builder', 'jnews' ),
						'slug'               => 'elementor',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'builder',
						'description'        => esc_html__( 'The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/elementor.png',
						),
					),
				),
			),
			'style-editor'          => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Styling Editor', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'YellowPencil Pro', 'jnews' ),
						'slug'             => 'waspthemes-yellow-pencil',
						'source'           => 'waspthemes-yellow-pencil.zip',
						'version'          => '7.6',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => false,
						'group'            => 'style-editor',
						'description'      => esc_html__( 'The most advanced visual CSS editor. Customize any theme and any page in real-time without coding', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/yellow-pencil.png',
						),
					),
				),
			),
			'breadcrumb'            => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Breadcrumb', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Breadcrumb', 'jnews' ),
						'slug'             => 'jnews-breadcrumb',
						'version'          => '10.0.1',
						'source'           => 'jnews-breadcrumb.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'breadcrumb',
						'description'      => esc_html__( 'Breadcrumb Plugin for JNews Themes. This plugin also work perfectly with JNews - JSON LD Rich Snipet plugin', 'jnews' ),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_global_breadcrumb_section',
								'newtab' => true,
							),
						),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-breadcrumb.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'richsnippet'           => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Rich Snippet', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - JSON LD Rich Snippet', 'jnews' ),
						'slug'             => 'jnews-jsonld',
						'version'          => '11.0.2',
						'source'           => 'jnews-jsonld.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'richsnippet',
						'description'      => esc_html__( 'Rich snippet for JNews with JSON LD Form. JSON LD is newest version of Rich snippet. and becoming future of rich snippet.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-jsonld.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[panel]=jnews_global_seo',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'social'                => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Social Share & Counter', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - View Counter', 'jnews' ),
						'slug'             => 'jnews-view-counter',
						'version'          => '11.0.1',
						'source'           => 'jnews-view-counter.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'counter',
						'description'      => esc_html__( 'Custom view counter for JNews. Add functionality for showing top daily, weekly, monthly post', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-view-counter.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_view_counter',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Social Share', 'jnews' ),
						'slug'             => 'jnews-social-share',
						'version'          => '11.0.2',
						'source'           => 'jnews-social-share.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'social',
						'description'      => esc_html__( 'Social bar, Social Counter and Initial Counter functionality for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-social-share.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_social_like_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'meta-share'            => array(
				'type'  => 'recommended',
				'title' => esc_html__( 'Meta Header (Share)', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Meta Header', 'jnews' ),
						'slug'             => 'jnews-meta-header',
						'version'          => '11.0.3',
						'source'           => 'jnews-meta-header.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => false,
						'group'            => 'meta-share',
						'description'      => esc_html__( 'Plugin to customize Meta Header (Facebook share / Twitter Card)', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-meta-header.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_social_meta_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'paywall'               => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Paywall', 'jnews' ),
				'notice' => esc_html__( 'Please install all plugins below to activate all paywall features', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'JNews - Paywall', 'jnews' ),
						'slug'               => 'jnews-paywall',
						'version'            => '11.0.3',
						'source'             => 'jnews-paywall.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'paywall',
						'description'        => esc_html__( 'Member subscription for reading posts in JNews Theme', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-paywall.png',
						),
						'link'               => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[panel]=jnews_paywall_panel',
								'newtab' => true,
							),
						),
						'flag'               => 'jnews',
					),
					array(
						'name'               => esc_html__( 'WooCommerce', 'jnews' ),
						'slug'               => 'woocommerce',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'paywall',
						'description'        => esc_html__( 'WooCommerce is a flexible, open-source eCommerce solution built on WordPress.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/woocommerce.png',
						),
					),
				),
			),
			'pay-writer'            => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Pay Writer', 'jnews' ),
				'items' => array(
					array(
						'name'               => esc_html__( 'JNews - Pay Writer', 'jnews' ),
						'slug'               => 'jnews-pay-writer',
						'version'            => '11.0.1',
						'source'             => 'jnews-pay-writer.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'pay-writer',
						'description'        => esc_html__( 'Provide authors payment and donation for the post they made. easily configure how much author can earn for a post by payment option', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-pay-writer.png',
						),
						'link'               => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[panel]=jnews_pay_writer_panel',
								'newtab' => true,
							),
						),
						'flag'               => 'jnews',
					),
				),
			),
			'video'                 => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Video Mode', 'jnews' ),
				'notice' => esc_html__( 'Please install all plugins below to activate video mode', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'JNews - Video', 'jnews' ),
						'slug'               => 'jnews-video',
						'version'            => '11.0.3',
						'source'             => 'jnews-video.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'video',
						'description'        => esc_html__( 'Plugin to enable video mode', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-video.png',
						),
						'link'               => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[panel]=jnews_video',
								'newtab' => true,
							),
						),
						'flag'               => 'jnews',
					),
					array(
						'name'               => esc_html__( 'BuddyPress', 'jnews' ),
						'slug'               => 'buddypress',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'video',
						'description'        => esc_html__( 'Fun & flexible software for online communities, teams, and groups.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/buddypress.png',
						),
					),
					array(
						'name'               => esc_html__( 'BuddyPress Follow', 'jnews' ),
						'slug'               => 'buddypress-followers',
						'version'            => '1.3-alpha',
						'source'             => 'buddypress-followers.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'video',
						'description'        => esc_html__( 'Follow members on your BuddyPress site with this nifty plugin.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/buddypress-follow.png',
						),
					),
				),
			),
			'podcast'               => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Podcast Mode', 'jnews' ),
				'notice' => esc_html__( 'Only install PowerPress Podcasting plugin if you need to import podcast or you are familiar with the plugin', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'JNews - Podcast', 'jnews' ),
						'slug'               => 'jnews-podcast',
						'version'            => '11.0.3',
						'source'             => 'jnews-podcast.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'podcast',
						'description'        => esc_html__( 'Plugin to enable podcast mode', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-podcast.png',
						),
						'link'               => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[panel]=jnews_podcast',
								'newtab' => true,
							),
						),
						'flag'               => 'jnews',
					),
					array(
						'name'               => esc_html__( 'PowerPress Podcasting plugin by Blubrry', 'jnews' ),
						'slug'               => 'powerpress',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'podcast',
						'description'        => esc_html__( 'Blubrry PowerPress is the No. 1 Podcasting plugin for WordPress. Developed by podcasters for podcasters; features include Simple and Advanced modes, multiple audio/video player options, subscribe to podcast tools, podcast SEO features, and more! Fully supports Apple Podcasts (previously iTunes), Google Podcasts, Spotify, Stitcher, and Blubrry Podcasting directories, as well as all podcast applications and clients.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/powerpress.png',
						),
					),
				),
			),
			'classic-editor'        => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Classic Editor', 'jnews' ),
				'notice' => esc_html__( 'Classic Editor is an official plugin maintained by the WordPress team that restores the previous (“classic”) WordPress editor and the “Edit Post” screen. By default, this plugin hides all functionality available in the new Block Editor (“Gutenberg”).', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'Classic Editor', 'jnews' ),
						'slug'               => 'classic-editor',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'classic-editor',
						'description'        => esc_html__( 'Enables the WordPress classic editor and the old-style Edit Post screen with TinyMCE, Meta Boxes, etc. Supports the older plugins that extend this screen.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/classic-editor.png',
						),
					),
				),
			),
			'gutenberg'             => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Gutenberg Blocks', 'jnews' ),
				'notice' => esc_html__( 'If you\'re using WordPress v4.9.8 or below, please install both of plugin to enable Gutenberg blocks. If you already using WordPress v5.0.0 or higher, you only need to install JNews - Gutenberg plugin.', 'jnews' ),
				'items'  => array(
					array(
						'name'               => esc_html__( 'Gutenberg', 'jnews' ),
						'slug'               => 'gutenberg',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'gutenberg',
						'description'        => esc_html__( 'Gutenberg is more than an editor. While the editor is the focus right now, the project will ultimately impact the entire publishing experience including customization (the next focus area).', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-gutenberg.png',
						),
					),
					array(
						'name'             => esc_html__( 'JNews - Gutenberg', 'jnews' ),
						'slug'             => 'jnews-gutenberg',
						'version'          => '10.0.1',
						'source'           => 'jnews-gutenberg.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'gutenberg',
						'description'      => esc_html__( 'Gutenberg extender plugin for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-gutenberg.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'frontend_submit'       => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Frontend Post Submit', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Frontend Submit', 'jnews' ),
						'slug'             => 'jnews-frontend-submit',
						'version'          => '10.0.2',
						'source'           => 'jnews-frontend-submit.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'frontend_submit',
						'description'      => esc_html__( 'Frontend submit article for JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-frontend-submit.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_frontend_submit_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'webstories'            => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'WebStories', 'jnews' ),
				'notice' => esc_html__( 'Please install both plugins (Google Web Stories & JNews Webstories) to enable Webstories on your website', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - Webstories', 'jnews' ),
						'slug'             => 'jnews-webstories',
						'version'          => '10.0.1',
						'source'           => 'jnews-webstories.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'webstories',
						'description'      => esc_html__( 'Webstories element for wordpress', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-webstories.png',
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'Google Web Stories', 'jnews' ),
						'slug'             => 'web-stories',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'web-stories',
						'description'      => esc_html__( 'Webstories builder for wordpress', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/google-web-stories.png',
						),
					),
				),
			),
			'amp'                   => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Google AMP', 'jnews' ),
				'notice' => esc_html__( 'Please install both plugins (JNews AMP & WordPress AMP) to enable AMP on your website', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - AMP', 'jnews' ),
						'slug'             => 'jnews-amp',
						'version'          => '11.0.1',
						'source'           => 'jnews-amp.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'amp',
						'description'      => esc_html__( 'Extend WordPress AMP to fit with JNews Style', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-amp.png',
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'WordPress AMP', 'jnews' ),
						'slug'             => 'amp',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'amp',
						'description'      => esc_html__( 'Add AMP support to your WordPress site.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/amp.png',
						),
					),
				),
			),
			'autoload'              => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Autoload Post When Scrolling', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Auto Load Post', 'jnews' ),
						'slug'             => 'jnews-auto-load-post',
						'version'          => '11.0.2',
						'source'           => 'jnews-auto-load-post.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'autoload',
						'description'      => esc_html__( 'Auto load next post when scroll for JNews', 'jnews' ),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_autoload_section',
								'newtab' => true,
							),
						),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-auto-load-post.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'category'              => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Modify Every Category Layout', 'jnews' ),
				'notice' => wp_kses( __( 'Please only enable one of this plugin to modify every category layout. <ul><li><strong>JNews - Customize Detail Category</strong> Use this plugin if you only have small number of category</li><li><strong>JNews - Extended Category Option</strong> Use this plugin if you only have large number of category</li></ul>', 'jnews' ), wp_kses_allowed_html() ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - Customize Detail Category', 'jnews' ),
						'slug'             => 'jnews-customizer-category',
						'version'          => '10.0.1',
						'source'           => 'jnews-customizer-category.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'category',
						'description'      => esc_html__( 'Customize and overwrite detail layout of every global category on your website', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-customizer-category.png',
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Extended Category Option', 'jnews' ),
						'slug'             => 'jnews-option-category',
						'version'          => '10.0.3',
						'source'           => 'jnews-option-category.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'category',
						'description'      => esc_html__( 'Option and overwrite detail layout of every global category on your website. Recommended for handling large amount of category', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-customizer-category.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'translation'           => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Translation', 'jnews' ),
				'notice' => esc_html__( 'We provide easy method to translate frontend string. However, if you need to translate the whole string on theme (including backend), you can use loco translate.', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - Frontend Translation', 'jnews' ),
						'slug'             => 'jnews-front-translation',
						'version'          => '11.0.1',
						'source'           => 'jnews-front-translation.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'translation',
						'description'      => esc_html__( 'Easy translation tool for JNews. This plugin will only give option for frontend wording. Backend translation still need to be translated using PO / MO File', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-front-translation.png',
						),
						'link'             => array(
							array(
								'title'  => 'Translate',
								'url'    => get_admin_url() . 'admin.php?page=jnews_translation',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),

				),
			),
			'gallery'               => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Gallery', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Gallery', 'jnews' ),
						'slug'             => 'jnews-gallery',
						'version'          => '11.0.2',
						'source'           => 'jnews-gallery.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'gallery',
						'description'      => esc_html__( 'Alter your default WordPress post gallery to more beautiful gallery', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-gallery.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_preview_slider_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'instagram'             => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Instagram Feed', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Instagram Feed', 'jnews' ),
						'slug'             => 'jnews-instagram',
						'version'          => '11.0.1',
						'source'           => 'jnews-instagram.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'instagram',
						'description'      => esc_html__( 'Put your instagram feed on your website footer', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-instagram.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_footer_footer_instagram_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'tiktok'                => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Tiktok Feed', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Tiktok Feed', 'jnews' ),
						'slug'             => 'jnews-tiktok',
						'version'          => '11.0.1',
						'source'           => 'jnews-tiktok.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'tiktok',
						'description'      => esc_html__( 'TikTok widget and element for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-tiktok.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'like'                  => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Like Button', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Like Button', 'jnews' ),
						'slug'             => 'jnews-like',
						'version'          => '10.0.0',
						'source'           => 'jnews-like.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'like',
						'description'      => esc_html__( 'JNews Like functionality for single post', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-like.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_like_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'bookmark'              => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Bookmark Button', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Bookmark Button', 'jnews' ),
						'slug'             => 'jnews-bookmark',
						'version'          => '10.0.1',
						'source'           => 'jnews-bookmark.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'like',
						'description'      => esc_html__( 'JNews Like functionality for single post', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-bookmark.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_bookmark_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'review'                => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Review', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Review', 'jnews' ),
						'slug'             => 'jnews-review',
						'version'          => '10.0.4',
						'source'           => 'jnews-review.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'review',
						'description'      => esc_html__( 'Review Plugin for JNews. Also Provide additional option to show where to buy item that you review. Great for Internet Marketer to sell their product.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-review.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_review_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'food-recipe'           => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Food Recipe', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Food Recipe', 'jnews' ),
						'slug'             => 'jnews-food-recipe',
						'version'          => '10.0.2',
						'source'           => 'jnews-food-recipe.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'food-recipe',
						'description'      => esc_html__( 'Food Recipe Plugin for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-food-recipe.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'social-login'          => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Social Login & Registration', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Social Login', 'jnews' ),
						'slug'             => 'jnews-social-login',
						'version'          => '11.0.2',
						'source'           => 'jnews-social-login.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'social-login',
						'description'      => esc_html__( 'Social Login & Registration Plugin for JNews Themes', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-social-login.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'customize.php?autofocus[section]=jnews_social_login_section',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'speed'                 => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Speed up your website', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'WP Super Cache', 'jnews' ),
						'slug'             => 'wp-super-cache',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'speed',
						'description'      => esc_html__( 'Very fast caching plugin for WordPress.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/wp-super-cache.png',
						),
					),
					array(
						'name'             => esc_html__( 'Autoptimize', 'jnews' ),
						'slug'             => 'autoptimize',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'speed',
						'description'      => esc_html__( 'Makes your site faster by optimizing CSS, JS, Images, Google fonts and more.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/autoptimize.png',
						),
						'link'             => array(
							array(
								'title'  => 'Option',
								'url'    => get_admin_url() . 'options-general.php?page=autoptimize',
								'newtab' => true,
							),
						),
					),
				),
			),
			'split'                 => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Split Post', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Split', 'jnews' ),
						'slug'             => 'jnews-split',
						'version'          => '10.0.4',
						'source'           => 'jnews-split.zip',
						'required'         => false,
						'force_activation' => false,
						'group'            => 'split',
						'description'      => esc_html__( 'Get more click by split post into several page. Work with normal load and ajax load.', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-split.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'weather'               => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Weather Forecast', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - Weather', 'jnews' ),
						'slug'             => 'jnews-weather',
						'version'          => '11.0.1',
						'source'           => 'jnews-weather.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => false,
						'group'            => 'weather',
						'description'      => esc_html__( 'Weather Forecast Plugin for JNews Themes', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-weather.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'push-notification'     => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Desktop Push Notification', 'jnews' ),
				'notice' => esc_html__( 'Please install both plugin (OneSignal & JNews Push Notification) to enable desktop push notification on your website', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'OneSignal - Free Web Push Notifications', 'jnews' ),
						'slug'             => 'onesignal-free-web-push-notifications',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'push-notification',
						'description'      => esc_html__( 'Increase engagement and drive more repeat traffic to your WordPress site with desktop push notifications', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/onesignal.png',
						),
					),
					array(
						'name'             => esc_html__( 'JNews - Push Notification', 'jnews' ),
						'slug'             => 'jnews-push-notification',
						'version'          => '10.0.1',
						'source'           => 'jnews-push-notification.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => false,
						'group'            => 'push-notification',
						'description'      => esc_html__( 'Desktop push notification plugin for JNews Themes', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-push-notification.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'subscribe-to-download' => array(
				'type'   => 'optional',
				'title'  => esc_html__( 'Subscribe to Download', 'jnews' ),
				'notice' => esc_html__( 'Please make sure SMTP on your website is properly configured', 'jnews' ),
				'items'  => array(
					array(
						'name'             => esc_html__( 'JNews - Subscribe to Download', 'jnews' ),
						'slug'             => 'jnews-subscribe-to-download',
						'version'          => '10.0.1',
						'source'           => 'jnews-subscribe-to-download.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => false,
						'group'            => 'subscribe-to-download',
						'description'      => esc_html__( 'Subscribe to download functionality for JNews', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-subscribe.png',
						),
						'flag'             => 'jnews',
					),
				),
			),
			'migrate'               => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Migration', 'jnews' ),
				'items' => array(
					array(
						'name'             => esc_html__( 'JNews - JMagz Migration', 'jnews' ),
						'slug'             => 'jnews-migration-jmagz',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-jmagz.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from JMagz Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-jmagz.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_jmagz',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Newspaper Migration', 'jnews' ),
						'slug'             => 'jnews-migration-newspaper',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-newspaper.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Newspaper Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-newspaper.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_newspaper',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Publisher Migration', 'jnews' ),
						'slug'             => 'jnews-migration-publisher',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-publisher.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Publisher Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-publisher.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_publisher',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Jannah Migration', 'jnews' ),
						'slug'             => 'jnews-migration-jannah',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-jannah.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Jannah Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-jannah.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_jannah',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Sahifa Migration', 'jnews' ),
						'slug'             => 'jnews-migration-sahifa',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-sahifa.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Sahifa Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-sahifa.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_sahifa',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Soledad Migration', 'jnews' ),
						'slug'             => 'jnews-migration-soledad',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-soledad.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Soledad Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-soledad.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_soledad',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
					array(
						'name'             => esc_html__( 'JNews - Newsmag Migration', 'jnews' ),
						'slug'             => 'jnews-migration-newsmag',
						'version'          => '10.1.0',
						'source'           => 'jnews-migration-newsmag.zip',
						'required'         => false,
						'force_activation' => false,
						'refresh'          => true,
						'group'            => 'migrate',
						'description'      => esc_html__( 'Content migration plugin from Newsmag Theme into JNews Theme', 'jnews' ),
						'detail'           => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/jnews-migration-newsmag.png',
						),
						'link'             => array(
							array(
								'title'  => 'Migration',
								'url'    => get_admin_url() . 'admin.php?page=jnews_migration_newmag',
								'newtab' => true,
							),
						),
						'flag'             => 'jnews',
					),
				),
			),
			'slider'                => array(
				'type'  => 'optional',
				'title' => esc_html__( 'Slider Revolution', 'jnews' ),
				'items' => array(
					array(
						'name'               => esc_html__( 'Slider Revolution', 'jnews' ),
						'slug'               => 'revslider',
						'version'            => '6.5.24',
						'source'             => 'revslider.zip',
						'required'           => false,
						'force_activation'   => false,
						'force_deactivation' => false,
						'refresh'            => true,
						'group'              => 'slider',
						'description'        => esc_html__( 'An innovative responsive WordPress Slider Plugin that displays your content the beautiful way.', 'jnews' ),
						'detail'             => array(
							'image' => JNEWS_THEME_URL . '/assets/img/plugin/revslider.png',
						),
					),
				),
			),
		);

		return $groups;
	}
	function jnews_plugin_list() {
		$plugins = array();
		$groups  = jnews_plugin_group();

		foreach ( $groups as $key => $group ) {
			$plugins = array_merge( $plugins, $group['items'] );
		}

		return $plugins;
	}

	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	function jnews_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = jnews_plugin_list();

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'jnews',                              // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => JNEWS_THEME_DIR . 'plugins/',         // Default absolute path to bundled plugins.
			'menu'         => 'jnews-install-plugins',              // Menu slug.
			'has_notices'  => true,                                 // Show admin notices or not.
			'dismissable'  => true,                                 // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                                   // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                                // Automatically activate plugins after installation or not.
			'message'      => '',                                   // Message to output right before the plugins table.
		);

		jnews_tgmpa( $plugins, $config );
	}
}

add_action(
	'init',
	function () {
		jnews_admin_topbar_menu( 'jnews_plugin_update_notice', 99 );
	}
);

/**
 * @param WP_Admin_Bar $admin_bar
 */
function jnews_plugin_update_notice( $admin_bar ) {
	$revert_dashboard = apply_filters( 'jnews_revert_dashboard', false );
	$plugins          = \JNews\Util\Api\Plugin::get_plugin_list();
	$slug             = apply_filters( 'jnews_get_admin_slug', '' );
	$admin_url        = defined( 'JNEWS_ESSENTIAL' ) ? 'admin.php' : 'themes.php';
	$all_plugins      = get_plugins();
	foreach ( $plugins as $id => $detail ) {
		if ( isset( $detail['file'] ) && ! empty( $all_plugins[ $detail['file'] ] ) ) {
			$minimum_version   = $detail['version'];
			$installed_version = $all_plugins[ $detail['file'] ]['Version'];
			if ( is_plugin_active( $detail['file'] ) && version_compare( $minimum_version, $installed_version, '>' ) ) {
				if ( is_admin() ) {
					do_action( 'jnews_update_plugins' );
				}
				$admin_bar->add_menu(
					array(
						'id'    => 'jnews',
						'title' => '<span class="ab-icon"></span>JNews - Notification',
						'href'  => '#',
						'meta'  => array(
							'class' => 'jnews-notice',
						),
					)
				);

				$admin_bar->add_menu(
					array(
						'parent' => 'jnews',
						'id'     => 'update-plugin',
						'title'  => 'Some Plugin Need Update',
						'href'   => $revert_dashboard ? admin_url( $admin_url . '?page=jnews_plugin' ) : admin_url( $admin_url . '?page=' . $slug['dashboard'] . '&path=' . $slug['plugin'] ),
						'meta'   => array(
							'class' => 'jnews-notice',
						),
					)
				);
			}
		}
	}
}
