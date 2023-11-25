<?php

return array(
	'jeg-ai-assistant'                      => array(
		'name'             => 'JegAI Assistant',
		'slug'             => 'jeg-ai-assistant',
		'version'          => '1.2.1',
		'file'             => 'jeg-ai-assistant/jeg-ai-assistant.php',
		'source'           => 'jeg-ai-assistant.zip',
		'recommended'      => true,
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'seo',
			'recommend',
			'editor',
			'interactive',
			'engagement',
		),
		'description'      => '-',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jeg-ai-assistant.png',
		),
		'flag'             => 'jnews',
	),
	'leadin'                                => array(
		'name'               => 'HubSpot - CRM & Marketing',
		'slug'               => 'leadin',
		'recommended'        => true,
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'recommend',
		),
		'description'        => 'HubSpot is a platform with all the tools and integrations you need for marketing, sales, and customer service.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/hubspot.png',
		),
	),
	'jnews-essential'                       => array(
		'name'             => 'JNews - Essential',
		'slug'             => 'jnews-essential',
		'version'          => '11.0.7',
		'file'             => 'jnews-essential/jnews-essential.php',
		'source'           => 'jnews-essential.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'require',
		),
		'description'      => 'Advertisement, Shortcode & Widget for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-customizer-category.png',
		),
		'flag'             => 'jnews',
	),
	'vafpress-post-formats-ui-develop'      => array(
		'name'               => 'Vafpress Post Formats UI',
		'slug'               => 'vafpress-post-formats-ui-develop',
		'version'            => '1.5.3',
		'file'               => 'vafpress-post-formats-ui-develop/vafpress-post-formats-ui-develop.php',
		'source'             => 'vafpress-post-formats-ui-develop.zip',
		'required'           => true,
		'force_activation'   => false,
		'force_deactivation' => false,
		'group'              => array(
			'require',
		),
		'description'        => 'Custom post format admin UI',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/vafpress.png',
		),
	),
	'js_composer'                           => array(
		'name'               => 'WPBakery Visual Composer',
		'slug'               => 'js_composer',
		'version'            => '7.0',
		'file'               => 'js_composer/js_composer.php',
		'source'             => 'js_composer.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'builder',
		),
		'description'        => 'Drag and drop page builder for WordPress. Take full control over your WordPress site, build any layout you can imagine  &dash; no programming knowledge required.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/vc.png',
		),
	),
	'elementor'                             => array(
		'name'               => 'Elementor Page Builder',
		'slug'               => 'elementor',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'builder',
		),
		'description'        => 'The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/elementor.png',
		),
	),
	'waspthemes-yellow-pencil'              => array(
		'name'             => 'YellowPencil Pro',
		'slug'             => 'waspthemes-yellow-pencil',
		'file'             => 'waspthemes-yellow-pencil/yellow-pencil.php',
		'source'           => 'waspthemes-yellow-pencil.zip',
		'version'          => '7.6',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => false,
		'group'            => array(
			'style-editor',
		),
		'description'      => 'The most advanced visual CSS editor. Customize any theme and any page in real-time without coding',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/yellow-pencil.png',
		),
	),
	'jnews-breadcrumb'                      => array(
		'name'             => 'JNews - Breadcrumb',
		'slug'             => 'jnews-breadcrumb',
		'version'          => '11.0.0',
		'file'             => 'jnews-breadcrumb/jnews-breadcrumb.php',
		'source'           => 'jnews-breadcrumb.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'seo',
		),
		'description'      => 'Breadcrumb Plugin for JNews Themes. This plugin also work perfectly with JNews - JSON LD Rich Snipet plugin',
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_global_breadcrumb_section',
				'newtab' => true,
			),
		),
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-breadcrumb.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-jsonld'                          => array(
		'name'             => 'JNews - JSON LD Rich Snippet',
		'slug'             => 'jnews-jsonld',
		'version'          => '11.0.2',
		'file'             => 'jnews-jsonld/jnews-jsonld.php',
		'source'           => 'jnews-jsonld.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'seo',
		),
		'description'      => 'Rich snippet for JNews with JSON LD Form. JSON LD is newest version of Rich snippet. and becoming future of rich snippet.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-jsonld.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[panel]=jnews_global_seo',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-view-counter'                    => array(
		'name'             => 'JNews - View Counter',
		'slug'             => 'jnews-view-counter',
		'version'          => '11.0.1',
		'file'             => 'jnews-view-counter/jnews-view-counter.php',
		'source'           => 'jnews-view-counter.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'social',
			'jnews-plus-pay-writer',
		),
		'description'      => 'Custom view counter for JNews. Add functionality for showing top daily, weekly, monthly post',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-view-counter.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_view_counter',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-social-share'                    => array(
		'name'             => 'JNews - Social Share',
		'slug'             => 'jnews-social-share',
		'version'          => '11.0.2',
		'file'             => 'jnews-social-share/jnews-social-share.php',
		'source'           => 'jnews-social-share.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'social',
		),
		'description'      => 'Social bar, Social Counter and Initial Counter functionality for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-social-share.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_social_like_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-meta-header'                     => array(
		'name'             => 'JNews - Meta Header',
		'slug'             => 'jnews-meta-header',
		'version'          => '11.0.3',
		'file'             => 'jnews-meta-header/jnews-meta-header.php',
		'source'           => 'jnews-meta-header.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => false,
		'group'            => array(
			'seo',
			'social',
		),
		'description'      => 'Plugin to customize Meta Header (Facebook share / Twitter Card)',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-meta-header.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_social_meta_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-paywall'                         => array(
		'name'               => 'JNews - Paywall',
		'slug'               => 'jnews-paywall',
		'version'            => '11.0.3',
		'file'               => 'jnews-paywall/jnews-paywall.php',
		'source'             => 'jnews-paywall.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-paywall',
		),
		'description'        => 'Member subscription for reading posts in JNews Theme',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-paywall.png',
		),
		'link'               => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[panel]=jnews_paywall_panel',
				'newtab' => true,
			),
		),
		'flag'               => 'jnews',
	),
	'woocommerce'                           => array(
		'name'               => 'WooCommerce',
		'slug'               => 'woocommerce',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-paywall',
		),
		'description'        => 'WooCommerce is a flexible, open-source eCommerce solution built on WordPress.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/woocommerce.png',
		),
	),
	'jnews-pay-writer'                      => array(
		'name'               => 'JNews - Pay Writer',
		'slug'               => 'jnews-pay-writer',
		'version'            => '11.0.1',
		'file'               => 'jnews-pay-writer/jnews-pay-writer.php',
		'source'             => 'jnews-pay-writer.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-pay-writer',
		),
		'description'        => 'Provide authors payment and donation for the post they made. easily configure how much author can earn for a post by payment option',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-pay-writer.png',
		),
		'link'               => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[panel]=jnews_pay_writer_panel',
				'newtab' => true,
			),
		),
		'flag'               => 'jnews',
	),
	'jnews-video'                           => array(
		'name'               => 'JNews - Video',
		'slug'               => 'jnews-video',
		'version'            => '11.0.3',
		'file'               => 'jnews-video/jnews-video.php',
		'source'             => 'jnews-video.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-video',
		),
		'description'        => 'Plugin to enable video mode',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-video.png',
		),
		'link'               => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[panel]=jnews_video',
				'newtab' => true,
			),
		),
		'flag'               => 'jnews',
	),
	'buddypress'                            => array(
		'name'               => 'BuddyPress',
		'slug'               => 'buddypress',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-video',
		),
		'description'        => 'Fun & flexible software for online communities, teams, and groups.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/buddypress.png',
		),
	),
	'buddypress-followers'                  => array(
		'name'               => 'BuddyPress Follow',
		'slug'               => 'buddypress-followers',
		'version'            => '1.3-alpha',
		'file'               => 'buddypress-followers/loader.php',
		'source'             => 'buddypress-followers.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-video',
		),
		'description'        => 'Follow members on your BuddyPress site with this nifty plugin.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/buddypress-follow.png',
		),
	),
	'jnews-podcast'                         => array(
		'name'               => 'JNews - Podcast',
		'slug'               => 'jnews-podcast',
		'version'            => '11.0.3',
		'file'               => 'jnews-podcast/jnews-podcast.php',
		'source'             => 'jnews-podcast.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-podcast',
		),
		'description'        => 'Plugin to enable podcast mode',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-podcast.png',
		),
		'link'               => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[panel]=jnews_podcast',
				'newtab' => true,
			),
		),
		'flag'               => 'jnews',
	),
	'powerpress'                            => array(
		'name'               => 'PowerPress Podcasting plugin by Blubrry',
		'slug'               => 'powerpress',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'jnews-plus-podcast',
		),
		'description'        => 'Blubrry PowerPress is the No. 1 Podcasting plugin for WordPress. Developed by podcasters for podcasters; features include Simple and Advanced modes, multiple audio/video player options, subscribe to podcast tools, podcast SEO features, and more! Fully supports Apple Podcasts (previously iTunes), Google Podcasts, Spotify, Stitcher, and Blubrry Podcasting directories, as well as all podcast applications and clients.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/powerpress.png',
		),
	),
	'classic-editor'                        => array(
		'name'               => 'Classic Editor',
		'slug'               => 'classic-editor',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'editor',
		),
		'description'        => 'Enables the WordPress classic editor and the old-style Edit Post screen with TinyMCE, Meta Boxes, etc. Supports the older plugins that extend this screen.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/classic-editor.png',
		),
	),
	'gutenberg'                             => array(
		'name'               => 'Gutenberg',
		'slug'               => 'gutenberg',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'editor',
		),
		'description'        => 'Gutenberg is more than an editor. While the editor is the focus right now, the project will ultimately impact the entire publishing experience including customization (the next focus area).',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-gutenberg.png',
		),
	),
	'jnews-gutenberg'                       => array(
		'name'             => 'JNews - Gutenberg',
		'slug'             => 'jnews-gutenberg',
		'version'          => '11.0.0',
		'file'             => 'jnews-gutenberg/jnews-gutenberg.php',
		'source'           => 'jnews-gutenberg.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'editor',
		),
		'description'      => 'Gutenberg extender plugin for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-gutenberg.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-frontend-submit'                 => array(
		'name'             => 'JNews - Frontend Submit',
		'slug'             => 'jnews-frontend-submit',
		'version'          => '11.0.0',
		'file'             => 'jnews-frontend-submit/jnews-frontend-submit.php',
		'source'           => 'jnews-frontend-submit.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'editor',
		),
		'description'      => 'Frontend submit article for JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-frontend-submit.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_frontend_submit_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-webstories'                      => array(
		'name'             => 'JNews - Webstories',
		'slug'             => 'jnews-webstories',
		'version'          => '11.0.0',
		'file'             => 'jnews-webstories/jnews-webstories.php',
		'source'           => 'jnews-webstories.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array( 'interactive' ),
		'description'      => 'Webstories element for wordpress',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-webstories.png',
		),
		'flag'             => 'jnews',
	),
	'web-stories'                           => array(
		'name'             => 'Google Web Stories',
		'slug'             => 'web-stories',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array( 'interactive' ),
		'description'      => 'Webstories builder for wordpress',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/google-web-stories.png',
		),
	),
	'jnews-amp'                             => array(
		'name'             => 'JNews - AMP',
		'slug'             => 'jnews-amp',
		'version'          => '11.0.1',
		'file'             => 'jnews-amp/jnews-amp.php',
		'source'           => 'jnews-amp.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'seo',
		),
		'description'      => 'Extend WordPress AMP to fit with JNews Style',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-amp.png',
		),
		'flag'             => 'jnews',
	),
	'amp'                                   => array(
		'name'             => 'WordPress AMP',
		'slug'             => 'amp',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'seo',
		),
		'description'      => 'Add AMP support to your WordPress site.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/amp.png',
		),
	),
	'jnews-auto-load-post'                  => array(
		'name'             => 'JNews - Auto Load Post',
		'slug'             => 'jnews-auto-load-post',
		'version'          => '11.0.2',
		'file'             => 'jnews-auto-load-post/jnews-auto-load-post.php',
		'source'           => 'jnews-auto-load-post.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'seo',
		),
		'description'      => 'Auto load next post when scroll for JNews',
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_autoload_section',
				'newtab' => true,
			),
		),
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-auto-load-post.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-customizer-category'             => array(
		'name'             => 'JNews - Customize Detail Category',
		'slug'             => 'jnews-customizer-category',
		'version'          => '11.0.0',
		'file'             => 'jnews-customizer-category/jnews-customizer-category.php',
		'source'           => 'jnews-customizer-category.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'style-editor',
		),
		'description'      => 'Customize and overwrite detail layout of every global category on your website',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-customizer-category.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-option-category'                 => array(
		'name'             => 'JNews - Extended Category Option',
		'slug'             => 'jnews-option-category',
		'version'          => '11.0.0',
		'file'             => 'jnews-option-category/jnews-option-category.php',
		'source'           => 'jnews-option-category.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'style-editor',
		),
		'description'      => 'Option and overwrite detail layout of every global category on your website. Recommended for handling large amount of category',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-customizer-category.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-front-translation'               => array(
		'name'             => 'JNews - Frontend Translation',
		'slug'             => 'jnews-front-translation',
		'version'          => '11.0.1',
		'file'             => 'jnews-front-translation/jnews-front-translation.php',
		'source'           => 'jnews-front-translation.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'translation',
		),
		'description'      => 'Easy translation tool for JNews. This plugin will only give option for frontend wording. Backend translation still need to be translated using PO / MO File',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-front-translation.png',
		),
		'link'             => array(

			array(
				'title'  => 'Translate',
				'url'    => '__admin_url__/admin.php?page=jnews_translation',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-gallery'                         => array(
		'name'             => 'JNews - Gallery',
		'slug'             => 'jnews-gallery',
		'version'          => '11.0.2',
		'file'             => 'jnews-gallery/jnews-gallery.php',
		'source'           => 'jnews-gallery.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'editor',
		),
		'description'      => 'Alter your default WordPress post gallery to more beautiful gallery',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-gallery.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_preview_slider_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-instagram'                       => array(
		'name'             => 'JNews - Instagram Feed',
		'slug'             => 'jnews-instagram',
		'version'          => '11.0.1',
		'file'             => 'jnews-instagram/jnews-instagram.php',
		'source'           => 'jnews-instagram.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'social',
		),
		'description'      => 'Put your instagram feed on your website footer',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-instagram.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_footer_footer_instagram_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-tiktok'                          => array(
		'name'             => 'JNews - Tiktok Feed',
		'slug'             => 'jnews-tiktok',
		'version'          => '11.0.1',
		'file'             => 'jnews-tiktok/jnews-tiktok.php',
		'source'           => 'jnews-tiktok.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'social',
		),
		'description'      => 'TikTok widget and element for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-tiktok.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-like'                            => array(
		'name'             => 'JNews - Like Button',
		'slug'             => 'jnews-like',
		'version'          => '11.0.0',
		'file'             => 'jnews-like/jnews-like.php',
		'source'           => 'jnews-like.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'interactive',
		),
		'description'      => 'JNews Like functionality for single post',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-like.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_like_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-bookmark'                        => array(
		'name'             => 'JNews - Bookmark Button',
		'slug'             => 'jnews-bookmark',
		'version'          => '11.0.0',
		'file'             => 'jnews-bookmark/jnews-bookmark.php',
		'source'           => 'jnews-bookmark.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'interactive',
		),
		'description'      => 'JNews Like functionality for single post',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-bookmark.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_bookmark_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-review'                          => array(
		'name'             => 'JNews - Review',
		'slug'             => 'jnews-review',
		'version'          => '11.0.0',
		'file'             => 'jnews-review/jnews-review.php',
		'source'           => 'jnews-review.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'interactive',
		),
		'description'      => 'Review Plugin for JNews. Also Provide additional option to show where to buy item that you review. Great for Internet Marketer to sell their product.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-review.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_review_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-food-recipe'                     => array(
		'name'             => 'JNews - Food Recipe',
		'slug'             => 'jnews-food-recipe',
		'version'          => '11.0.0',
		'file'             => 'jnews-food-recipe/jnews-food-recipe.php',
		'source'           => 'jnews-food-recipe.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'interactive',
		),
		'description'      => 'Food Recipe Plugin for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-food-recipe.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-social-login'                    => array(
		'name'             => 'JNews - Social Login',
		'slug'             => 'jnews-social-login',
		'version'          => '11.0.2',
		'file'             => 'jnews-social-login/jnews-social-login.php',
		'source'           => 'jnews-social-login.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'social',
		),
		'description'      => 'Social Login & Registration Plugin for JNews Themes',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-social-login.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/customize.php?autofocus[section]=jnews_social_login_section',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'wp-super-cache'                        => array(
		'name'             => 'WP Super Cache',
		'slug'             => 'wp-super-cache',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'speed',
		),
		'description'      => 'Very fast caching plugin for WordPress.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/wp-super-cache.png',
		),
	),
	'autoptimize'                           => array(
		'name'             => 'Autoptimize',
		'slug'             => 'autoptimize',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'speed',
		),
		'description'      => 'Makes your site faster by optimizing CSS, JS, Images, Google fonts and more.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/autoptimize.png',
		),
		'link'             => array(

			array(
				'title'  => 'Option',
				'url'    => '__admin_url__/options-general.php?page=autoptimize',
				'newtab' => true,
			),
		),
	),
	'jnews-split'                           => array(
		'name'             => 'JNews - Split',
		'slug'             => 'jnews-split',
		'version'          => '11.0.0',
		'file'             => 'jnews-split/jnews-split.php',
		'source'           => 'jnews-split.zip',
		'required'         => false,
		'force_activation' => false,
		'group'            => array(
			'seo',
		),
		'description'      => 'Get more click by split post into several page. Work with normal load and ajax load.',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-split.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-weather'                         => array(
		'name'             => 'JNews - Weather',
		'slug'             => 'jnews-weather',
		'version'          => '11.0.1',
		'file'             => 'jnews-weather/jnews-weather.php',
		'source'           => 'jnews-weather.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => false,
		'group'            => array(
			'interactive',
		),
		'description'      => 'Weather Forecast Plugin for JNews Themes',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-weather.png',
		),
		'flag'             => 'jnews',
	),
	'onesignal-free-web-push-notifications' => array(
		'name'             => 'OneSignal - Free Web Push Notifications',
		'slug'             => 'onesignal-free-web-push-notifications',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'engagement',
		),
		'description'      => 'Increase engagement and drive more repeat traffic to your WordPress site with desktop push notifications',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/onesignal.png',
		),
	),
	'jnews-push-notification'               => array(
		'name'             => 'JNews - Push Notification',
		'slug'             => 'jnews-push-notification',
		'version'          => '11.0.0',
		'file'             => 'jnews-push-notification/jnews-push-notification.php',
		'source'           => 'jnews-push-notification.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => false,
		'group'            => array(
			'engagement',
		),
		'description'      => 'Desktop push notification plugin for JNews Themes',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-push-notification.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-subscribe-to-download'           => array(
		'name'             => 'JNews - Subscribe to Download',
		'slug'             => 'jnews-subscribe-to-download',
		'version'          => '11.0.0',
		'file'             => 'jnews-subscribe-to-download/jnews-subscribe-to-download.php',
		'source'           => 'jnews-subscribe-to-download.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => false,
		'group'            => array(
			'engagement',
		),
		'description'      => 'Subscribe to download functionality for JNews',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-subscribe.png',
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-jmagz'                 => array(
		'name'             => 'JNews - JMagz Migration',
		'slug'             => 'jnews-migration-jmagz',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-jmagz/jnews-migration-jmagz.php',
		'source'           => 'jnews-migration-jmagz.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from JMagz Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-jmagz.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_jmagz',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-newspaper'             => array(
		'name'             => 'JNews - Newspaper Migration',
		'slug'             => 'jnews-migration-newspaper',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-newspaper/jnews-migration-newspaper.php',
		'source'           => 'jnews-migration-newspaper.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Newspaper Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-newspaper.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_newspaper',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-publisher'             => array(
		'name'             => 'JNews - Publisher Migration',
		'slug'             => 'jnews-migration-publisher',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-publisher/jnews-migration-publisher.php',
		'source'           => 'jnews-migration-publisher.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Publisher Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-publisher.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_publisher',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-jannah'                => array(
		'name'             => 'JNews - Jannah Migration',
		'slug'             => 'jnews-migration-jannah',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-jannah/jnews-migration-jannah.php',
		'source'           => 'jnews-migration-jannah.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Jannah Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-jannah.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_jannah',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-sahifa'                => array(
		'name'             => 'JNews - Sahifa Migration',
		'slug'             => 'jnews-migration-sahifa',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-sahifa/jnews-migration-sahifa.php',
		'source'           => 'jnews-migration-sahifa.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Sahifa Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-sahifa.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_sahifa',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-soledad'               => array(
		'name'             => 'JNews - Soledad Migration',
		'slug'             => 'jnews-migration-soledad',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-soledad/jnews-migration-soledad.php',
		'source'           => 'jnews-migration-soledad.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Soledad Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-soledad.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_soledad',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'jnews-migration-newsmag'               => array(
		'name'             => 'JNews - Newsmag Migration',
		'slug'             => 'jnews-migration-newsmag',
		'version'          => '11.0.0',
		'file'             => 'jnews-migration-newsmag/jnews-migration-newsmag.php',
		'source'           => 'jnews-migration-newsmag.zip',
		'required'         => false,
		'force_activation' => false,
		'refresh'          => true,
		'group'            => array(
			'migrate',
		),
		'description'      => 'Content migration plugin from Newsmag Theme into JNews Theme',
		'detail'           => array(
			'image' => '__theme_url__/assets/img/plugin/jnews-migration-newsmag.png',
		),
		'link'             => array(

			array(
				'title'  => 'Migration',
				'url'    => '__admin_url__/admin.php?page=jnews_migration_newmag',
				'newtab' => true,
			),
		),
		'flag'             => 'jnews',
	),
	'revslider'                             => array(
		'name'               => 'Slider Revolution',
		'slug'               => 'revslider',
		'version'            => '6.6.12',
		'file'               => 'revslider/revslider.php',
		'source'             => 'revslider.zip',
		'required'           => false,
		'force_activation'   => false,
		'force_deactivation' => false,
		'refresh'            => true,
		'group'              => array(
			'interactive',
		),
		'description'        => 'An innovative responsive WordPress Slider Plugin that displays your content the beautiful way.',
		'detail'             => array(
			'image' => '__theme_url__/assets/img/plugin/revslider.png',
		),
	),
);
