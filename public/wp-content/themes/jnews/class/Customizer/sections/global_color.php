<?php

$options = [];

$options[] = [
	'id'    => 'jnews_scheme_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Website Scheme', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_scheme_color',
	'transport'   => 'refresh',
	'default'     => 'normal',
	'type'        => 'jnews-preset',
	'label'       => esc_html__( 'Choose your scheme color', 'jnews' ),
	'description' => esc_html__( 'This option will switch color option of your website. Header & footer option won\'t be affected by this option.', 'jnews' ),
	'choices'     => [
		'normal' => [
			'label'    => esc_html__( 'Normal', 'jnews' ),
			'settings' => [
				'jnews_body_color'           => '#53585c',
				'jnews_heading_color'        => '#212121',
				'jnews_container_background' => '#ffffff',
			],
		],
		'dark'   => [
			'label'    => esc_html__( 'Dark', 'jnews' ),
			'settings' => [
				'jnews_body_color'           => '#ffffff',
				'jnews_heading_color'        => '#ffffff',
				'jnews_container_background' => '#111111',
			],
		],
	],
];

$options[] = [
	'id'    => 'jnews_webstite_color_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Website Color', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_body_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '#53585c',
	'label'       => esc_html__( 'Base Text Color (Body)', 'jnews' ),
	'description' => esc_html__( 'Set body text color.', 'jnews' ),
	'output'      => [
		[
			/* Body Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-body-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => 'body,.jeg_newsfeed_list .tns-outer .tns-controls button,.jeg_filter_button,.owl-carousel .owl-nav div,.jeg_readmore,.jeg_hero_style_7 .jeg_post_meta a,.widget_calendar thead th,.widget_calendar tfoot a,.jeg_socialcounter a,.entry-header .jeg_meta_like a,.entry-header .jeg_meta_comment a,.entry-header .jeg_meta_donation a,.entry-header .jeg_meta_bookmark a,.entry-content tbody tr:hover,.entry-content th,.jeg_splitpost_nav li:hover a,#breadcrumbs a,.jeg_author_socials a:hover,.jeg_footer_content a,.jeg_footer_bottom a,.jeg_cartcontent,.woocommerce .woocommerce-breadcrumb a',
			'property' => 'color',
		],
	],
];

$options[] = [
	'id'          => 'jnews_accent_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '#f70d28',
	'label'       => esc_html__( 'Accent Color', 'jnews' ),
	'description' => esc_html__( 'Set general accent color.', 'jnews' ),
	'output'      => [
		[
			/* Accent Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-accent-color',
		],
		[
			/* Accent Color */
			'method'   => 'inject-style',
			'element'  => 'a, .jeg_menu_style_5>li>a:hover, .jeg_menu_style_5>li.sfHover>a, .jeg_menu_style_5>li.current-menu-item>a, .jeg_menu_style_5>li.current-menu-ancestor>a, .jeg_navbar .jeg_menu:not(.jeg_main_menu)>li>a:hover, .jeg_midbar .jeg_menu:not(.jeg_main_menu)>li>a:hover, .jeg_side_tabs li.active, .jeg_block_heading_5 strong, .jeg_block_heading_6 strong, .jeg_block_heading_7 strong, .jeg_block_heading_8 strong, .jeg_subcat_list li a:hover, .jeg_subcat_list li button:hover, .jeg_pl_lg_7 .jeg_thumb .jeg_post_category a, .jeg_pl_xs_2:before, .jeg_pl_xs_4 .jeg_postblock_content:before, .jeg_postblock .jeg_post_title a:hover, .jeg_hero_style_6 .jeg_post_title a:hover, .jeg_sidefeed .jeg_pl_xs_3 .jeg_post_title a:hover, .widget_jnews_popular .jeg_post_title a:hover, .jeg_meta_author a, .widget_archive li a:hover, .widget_pages li a:hover, .widget_meta li a:hover, .widget_recent_entries li a:hover, .widget_rss li a:hover, .widget_rss cite, .widget_categories li a:hover, .widget_categories li.current-cat>a, #breadcrumbs a:hover, .jeg_share_count .counts, .commentlist .bypostauthor>.comment-body>.comment-author>.fn, span.required, .jeg_review_title, .bestprice .price, .authorlink a:hover, .jeg_vertical_playlist .jeg_video_playlist_play_icon, .jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail:before, .jeg_horizontal_playlist .jeg_video_playlist_play, .woocommerce li.product .pricegroup .button, .widget_display_forums li a:hover, .widget_display_topics li:before, .widget_display_replies li:before, .widget_display_views li:before, .bbp-breadcrumb a:hover, .jeg_mobile_menu li.sfHover>a, .jeg_mobile_menu li a:hover, .split-template-6 .pagenum, .jeg_mobile_menu_style_5>li>a:hover, .jeg_mobile_menu_style_5>li.sfHover>a, .jeg_mobile_menu_style_5>li.current-menu-item>a, .jeg_mobile_menu_style_5>li.current-menu-ancestor>a',
			'property' => 'color',
		],
		[
			/* Accent Background */
			'method'   => 'inject-style',
			'element'  => '.jeg_menu_style_1>li>a:before, .jeg_menu_style_2>li>a:before, .jeg_menu_style_3>li>a:before, .jeg_side_toggle, .jeg_slide_caption .jeg_post_category a, .jeg_slider_type_1_wrapper .tns-controls button.tns-next, .jeg_block_heading_1 .jeg_block_title span, .jeg_block_heading_2 .jeg_block_title span, .jeg_block_heading_3, .jeg_block_heading_4 .jeg_block_title span, .jeg_block_heading_6:after, .jeg_pl_lg_box .jeg_post_category a, .jeg_pl_md_box .jeg_post_category a, .jeg_readmore:hover, .jeg_thumb .jeg_post_category a, .jeg_block_loadmore a:hover, .jeg_postblock.alt .jeg_block_loadmore a:hover, .jeg_block_loadmore a.active, .jeg_postblock_carousel_2 .jeg_post_category a, .jeg_heroblock .jeg_post_category a, .jeg_pagenav_1 .page_number.active, .jeg_pagenav_1 .page_number.active:hover, input[type="submit"], .btn, .button, .widget_tag_cloud a:hover, .popularpost_item:hover .jeg_post_title a:before, .jeg_splitpost_4 .page_nav, .jeg_splitpost_5 .page_nav, .jeg_post_via a:hover, .jeg_post_source a:hover, .jeg_post_tags a:hover, .comment-reply-title small a:before, .comment-reply-title small a:after, .jeg_storelist .productlink, .authorlink li.active a:before, .jeg_footer.dark .socials_widget:not(.nobg) a:hover .fa, div.jeg_breakingnews_title, .jeg_overlay_slider_bottom_wrapper .tns-controls button, .jeg_overlay_slider_bottom_wrapper .tns-controls button:hover, .jeg_vertical_playlist .jeg_video_playlist_current, .woocommerce span.onsale, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .jeg_popup_post .caption, .jeg_footer.dark input[type="submit"], .jeg_footer.dark .btn, .jeg_footer.dark .button, .footer_widget.widget_tag_cloud a:hover, .jeg_inner_content .content-inner .jeg_post_category a:hover, #buddypress .standard-form button, #buddypress a.button, #buddypress input[type="submit"], #buddypress input[type="button"], #buddypress input[type="reset"], #buddypress ul.button-nav li a, #buddypress .generic-button a, #buddypress .generic-button button, #buddypress .comment-reply-link, #buddypress a.bp-title-button, #buddypress.buddypress-wrap .members-list li .user-update .activity-read-more a, div#buddypress .standard-form button:hover, div#buddypress a.button:hover, div#buddypress input[type="submit"]:hover, div#buddypress input[type="button"]:hover, div#buddypress input[type="reset"]:hover, div#buddypress ul.button-nav li a:hover, div#buddypress .generic-button a:hover, div#buddypress .generic-button button:hover, div#buddypress .comment-reply-link:hover, div#buddypress a.bp-title-button:hover, div#buddypress.buddypress-wrap .members-list li .user-update .activity-read-more a:hover, #buddypress #item-nav .item-list-tabs ul li a:before, .jeg_inner_content .jeg_meta_container .follow-wrapper a',
			'property' => 'background-color',
		],
		[
			/* Accent Border Color */
			'method'   => 'inject-style',
			'element'  => '.jeg_block_heading_7 .jeg_block_title span, .jeg_readmore:hover, .jeg_block_loadmore a:hover, .jeg_block_loadmore a.active, .jeg_pagenav_1 .page_number.active, .jeg_pagenav_1 .page_number.active:hover, .jeg_pagenav_3 .page_number:hover, .jeg_prevnext_post a:hover h3, .jeg_overlay_slider .jeg_post_category, .jeg_sidefeed .jeg_post.active, .jeg_vertical_playlist.jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail img, .jeg_horizontal_playlist .jeg_video_playlist_item.active',
			'property' => 'border-color',
		],
		[
			/* Accent Border Color */
			'method'   => 'inject-style',
			'element'  => '.jeg_tabpost_nav li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .jeg_mobile_menu_style_1>li.current-menu-item a, .jeg_mobile_menu_style_1>li.current-menu-ancestor a, .jeg_mobile_menu_style_2>li.current-menu-item::after, .jeg_mobile_menu_style_2>li.current-menu-ancestor::after, .jeg_mobile_menu_style_3>li.current-menu-item::before, .jeg_mobile_menu_style_3>li.current-menu-ancestor::before',
			'property' => 'border-bottom-color',
		],
	],
];

$options[] = [
	'id'          => 'jnews_alt_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '#2e9fff',
	'label'       => esc_html__( 'Alternate Color', 'jnews' ),
	'description' => esc_html__( 'Alternate color including post meta icon & floated social share.', 'jnews' ),
	'output'      => [
		[
			/* Alt Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-alt-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.jeg_post_meta .fa, .jeg_post_meta .jpwt-icon, .entry-header .jeg_post_meta .fa, .jeg_review_stars, .jeg_price_review_list',
			'property' => 'color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.jeg_share_button.share-float.share-monocrhome a',
			'property' => 'background-color',
		],
	],
];

$options[] = [
	'id'          => 'jnews_heading_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '#212121',
	'label'       => esc_html__( 'Heading Color', 'jnews' ),
	'description' => esc_html__( 'Post title and other heading elements: H1, H2, H3, H4, H5 and H6.', 'jnews' ),
	'output'      => [
		[
			/* Heading Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-heading-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => 'h1,h2,h3,h4,h5,h6,.jeg_post_title a,.entry-header .jeg_post_title,.jeg_hero_style_7 .jeg_post_title a,.jeg_block_title,.jeg_splitpost_bar .current_title,.jeg_video_playlist_title,.gallery-caption,.jeg_push_notification_button>a.button',
			'property' => 'color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.split-template-9 .pagenum, .split-template-10 .pagenum, .split-template-11 .pagenum, .split-template-12 .pagenum, .split-template-13 .pagenum, .split-template-15 .pagenum, .split-template-18 .pagenum, .split-template-20 .pagenum, .split-template-19 .current_title span, .split-template-20 .current_title span',
			'property' => 'background-color',
		],
	],
];


$options[] = [
	'id'    => 'jnews_entry_color_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Entry Content', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_entry_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '',
	'label'       => esc_html__( 'Entry Content Color', 'jnews' ),
	'description' => esc_html__( 'General color for page and post entry content.', 'jnews' ),
	'output'      => [
		[
			/* Entry Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-entry-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.entry-content .content-inner p, .entry-content .content-inner span, .entry-content .intro-text',
			'property' => 'color',
		],
	],
];

$options[] = [
	'id'          => 'jnews_entry_link_color',
	'transport'   => 'postMessage',
	'type'        => 'jnews-color',
	'default'     => '',
	'label'       => esc_html__( 'Entry Link Color', 'jnews' ),
	'description' => esc_html__( 'General text link color of page and post entry content.', 'jnews' ),
	'output'      => [
		[
			/* Entry Link Color Variable */
			'method'   => 'inject-style',
			'element'  => 'body',
			'property' => '--j-entry-link-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.entry-content .content-inner a',
			'property' => 'color',
		],
	],
];

$options[] = [
	'id'          => 'jnews_entry_link_underline',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Enable Link Underline', 'jnews' ),
	'description' => esc_html__( 'Enable link underline of page and post entry content.', 'jnews' ),
	'output'      => [
		[
			'method'   => 'add-class',
			'element'  => '.entry-content .content-inner',
			'property' => 'jeg_link_underline',
		],
	],
];

return $options;
