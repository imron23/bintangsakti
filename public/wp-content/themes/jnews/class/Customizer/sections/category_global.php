<?php

$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

global $jnews_get_all_custom_archive_template; 

$content_layout = apply_filters( 'jnews_get_content_layout_customizer', [
	'3'  => '',
	'4'  => '',
	'5'  => '',
	'6'  => '',
	'7'  => '',
	'9'  => '',
	'10' => '',
	'11' => '',
	'12' => '',
	'14' => '',
	'15' => '',
	'18' => '',
	'22' => '',
	'23' => '',
	'25' => '',
	'26' => '',
	'27' => '',
	'32' => '',
	'33' => '',
	'34' => '',
	'35' => '',
	'36' => '',
	'37' => '',
	'38' => '',
	'39' => '',
] );

$options = [];

// color section
$options[] = [
	'id'    => 'jnews_category_color_section',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Category Color', 'jnews' ),
];

$options[] = [
	'id'            => 'jnews_category_global_bg_color',
	'transport'     => 'postMessage',
	'default'       => '#000000',
	'type'          => 'jnews-color',
	'disable_color' => true,
	'label'         => esc_html__( 'Background Color', 'jnews' ),
	'description'   => esc_html__( 'Choose color for your global category background color.', 'jnews' ),
	'output'        => [
		[
			'method'   => 'inject-style',
			'element'  => '.jeg_thumb .jeg_post_category a,.jeg_pl_lg_box .jeg_post_category a,.jeg_pl_md_box .jeg_post_category a,.jeg_postblock_carousel_2 .jeg_post_category a,.jeg_heroblock .jeg_post_category a,.jeg_slide_caption .jeg_post_category a',
			'property' => 'background-color',
		],
		[
			'method'   => 'inject-style',
			'element'  => '.jeg_overlay_slider .jeg_post_category,.jeg_thumb .jeg_post_category a,.jeg_pl_lg_box .jeg_post_category a,.jeg_pl_md_box .jeg_post_category a,.jeg_postblock_carousel_2 .jeg_post_category a,.jeg_heroblock .jeg_post_category a,.jeg_slide_caption .jeg_post_category a',
			'property' => 'border-color',
		],
	],
];

$options[] = [
	'id'            => 'jnews_category_global_text_color',
	'transport'     => 'postMessage',
	'default'       => '#ffffff',
	'type'          => 'jnews-color',
	'disable_color' => true,
	'label'         => esc_html__( 'Text Color', 'jnews' ),
	'description'   => esc_html__( 'Choose color for your global category text color.', 'jnews' ),
	'output'        => [
		[
			'method'   => 'inject-style',
			'element'  => '.jeg_thumb .jeg_post_category a,.jeg_pl_lg_box .jeg_post_category a,.jeg_pl_md_box .jeg_post_category a,.jeg_postblock_carousel_2 .jeg_post_category a,.jeg_heroblock .jeg_post_category a,.jeg_slide_caption .jeg_post_category a',
			'property' => 'color',
		],
	],
];

// sidebar section
$options[] = [
	'id'    => 'jnews_category_sidebar_section',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Category Page Layout', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_category_page_layout',
	'transport'   => 'postMessage',
	'default'     => 'right-sidebar',
	'type'        => 'jnews-radio-image',
	'label'       => esc_html__( 'Page Layout', 'jnews' ),
	'description' => esc_html__( 'Choose your page layout.', 'jnews' ),
	'choices'     => [
		'right-sidebar'        => '',
		'left-sidebar'         => '',
		'right-sidebar-narrow' => '',
		'left-sidebar-narrow'  => '',
		'double-sidebar'       => '',
		'double-right-sidebar' => '',
		'no-sidebar'           => '',
		'custom-template'      => '',
	],
	'postvar'     => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_custom_template_id',
	'transport'       => 'postMessage',
	'default'         => '',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Category Page Template List', 'jnews' ),
	'description'     => wp_kses( sprintf( __( 'Create custom category page template from <a href="%s" target="_blank">here</a>', 'jnews' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
	'choices'        => $jnews_get_all_custom_archive_template,
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '==',
			'value'    => 'custom-template',
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_custom_template_number_post',
	'transport'       => 'postMessage',
	'default'         => 10,
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Number of Post', 'jnews' ),
	'description'     => esc_html__( 'Set the number of post per page on category page.', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '==',
			'value'    => 'custom-template',
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Category Sidebar', 'jnews' ),
	'description'     => wp_kses( __( "Choose your category sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'no-sidebar',
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_second_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Second Category Sidebar', 'jnews' ),
	'description'     => wp_kses( __( "Choose your second sidebar for category page. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => 'in',
			'value'    => [ 'double-sidebar', 'double-right-sidebar' ],
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_sticky_sidebar',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Category Sticky Sidebar', 'jnews' ),
	'description'     => esc_html__( 'Enable sticky sidebar on global category page.', 'jnews' ),
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => true,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'no-sidebar',
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

// header type
$options[] = [
	'id'              => 'jnews_category_header_section',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Category Header', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_header',
	'transport'       => 'postMessage',
	'default'         => '1',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Category Header Style', 'jnews' ),
	'description'     => esc_html__( 'Category header: title and description type.', 'jnews' ),
	'multiple'        => 2,
	'choices'         => [
		'1' => '',
		'2' => '',
		'3' => '',
		'4' => '',
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_header_top'    => [
			'selector'        => '.jnews_category_header_top',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_header( 'top' ) );
			},
		],
		'jnews_category_header_bottom' => [
			'selector'        => '.jnews_category_header_bottom',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_header( 'bottom' ) );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_header_style',
	'transport'       => 'postMessage',
	'default'         => 'dark',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Title Background Color', 'jnews' ),
	'description'     => esc_html__( 'Choose color for your category title background color.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'normal' => esc_attr__( 'Normal Style (Light)', 'jnews' ),
		'dark'   => esc_attr__( 'Dark Style', 'jnews' ),
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_header',
			'operator' => 'in',
			'value'    => [ '3', '4' ],
		],
	],
	'output'          => [
		[
			'method'   => 'class-masking',
			'element'  => '.jeg_cat_header .jeg_cat_overlay',
			'property' => [
				'normal' => 'normal',
				'dark'   => 'dark',
			],
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_header_bg_color',
	'transport'       => 'postMessage',
	'default'         => '#f5f5f5',
	'type'            => 'jnews-color',
	'disable_color'   => true,
	'label'           => esc_html__( 'Title Background Color', 'jnews' ),
	'description'     => esc_html__( 'Choose color for your category title background color.', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_header',
			'operator' => 'in',
			'value'    => [ '3', '4' ],
		],
	],
	'output'          => [
		[
			'method'   => 'inline-css',
			'element'  => '.jeg_cat_bg',
			'property' => 'background-color',
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_header_bg_image',
	'transport'       => 'postMessage',
	'default'         => '',
	'type'            => 'jnews-image',
	'label'           => esc_html__( 'Title Background Image', 'jnews' ),
	'description'     => esc_html__( 'Choose or upload image for your category background.', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_header',
			'operator' => 'in',
			'value'    => [ '3', '4' ],
		],
	],
	'output'          => [
		[
			'method'   => 'inline-css',
			'element'  => '.jeg_cat_bg',
			'property' => 'background-image',
			'prefix'   => 'url("',
			'suffix'   => '")',
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

// hero type
$options[] = [
	'id'              => 'jnews_category_hero_section',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Category Hero', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero_show',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Category Hero Block', 'jnews' ),
	'description'     => esc_html__( 'Disable this option to hide category hero block.', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_hero_show' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero',
	'transport'       => 'postMessage',
	'default'         => '1',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Category Hero Header', 'jnews' ),
	'description'     => esc_html__( 'Choose your category header (hero).', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'1'    => '',
		'2'    => '',
		'3'    => '',
		'4'    => '',
		'5'    => '',
		'6'    => '',
		'7'    => '',
		'8'    => '',
		'9'    => '',
		'10'   => '',
		'11'   => '',
		'12'   => '',
		'13'   => '',
		'skew' => '',
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_hero_show',
			'operator' => '==',
			'value'    => true,
		],
	],
	'partial_refresh' => [
		'jnews_category_hero' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero_style',
	'transport'       => 'postMessage',
	'default'         => 'jeg_hero_style_1',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Category Hero Header Style', 'jnews' ),
	'description'     => esc_html__( 'Choose your category header (hero) style.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'jeg_hero_style_1' => '',
		'jeg_hero_style_2' => '',
		'jeg_hero_style_3' => '',
		'jeg_hero_style_4' => '',
		'jeg_hero_style_5' => '',
		'jeg_hero_style_6' => '',
		'jeg_hero_style_7' => '',
	],
	'partial_refresh' => [
		'jnews_category_hero_style' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_hero_show',
			'operator' => '==',
			'value'    => true,
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero_margin',
	'transport'       => 'postMessage',
	'default'         => 10,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Hero Margin', 'jnews' ),
	'description'     => esc_html__( 'Set margin of each hero element.', 'jnews' ),
	'choices'         => [
		'min'  => '0',
		'max'  => '30',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_category_hero_margin' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_hero_show',
			'operator' => '==',
			'value'    => true,
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero_date',
	'transport'       => 'postMessage',
	'default'         => 'default',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Hero Date Format', 'jnews' ),
	'description'     => esc_html__( 'Choose which date format you want to use for hero.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_category_hero_date' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_hero_show',
			'operator' => '==',
			'value'    => true,
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_hero_date_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Hero Date Format', 'jnews' ),
	'description'     => wp_kses( sprintf( __( "Please set custom date format for hero. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
		wp_kses_allowed_html() ),
	'partial_refresh' => [
		'jnews_category_hero_date_custom' => [
			'selector'        => '.jnews_category_hero_container',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_hero() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_hero_date',
			'operator' => '==',
			'value'    => 'custom',
		],
		[
			'setting'  => 'jnews_category_hero_show',
			'operator' => '==',
			'value'    => true,
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];


// content type
$options[] = [
	'id'              => 'jnews_category_content_section',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Category Content', 'jnews' ),
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content',
	'transport'       => 'postMessage',
	'default'         => '3',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Category Content Layout', 'jnews' ),
	'description'     => esc_html__( 'Choose your category content layout.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => $content_layout,
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_content' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_boxed',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Boxed', 'jnews' ),
	'description'     => esc_html__( 'This option will turn the module into boxed.', 'jnews' ),
	'partial_refresh' => [
		'jnews_category_boxed' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$category = new \JNews\Category\Category();
				echo jnews_sanitize_output( $category->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_content',
			'operator' => 'in',
			'value'    => [ '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ],
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_boxed_shadow',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Shadow', 'jnews' ),
	'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews' ),
	'partial_refresh' => [
		'jnews_category_boxed_shadow' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$category = new \JNews\Category\Category();
				echo jnews_sanitize_output( $category->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_content',
			'operator' => 'in',
			'value'    => [ '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ],
		],
		[
			'setting'  => 'jnews_category_boxed',
			'operator' => '==',
			'value'    => true,
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_box_shadow',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Shadow', 'jnews' ),
	'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews' ),
	'partial_refresh' => [
		'jnews_category_box_shadow' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$category = new \JNews\Category\Category();
				echo jnews_sanitize_output( $category->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_content',
			'operator' => 'in',
			'value'    => [ '37', '35', '33', '36', '32', '38' ],
		],
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_excerpt',
	'transport'       => 'postMessage',
	'default'         => 20,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Excerpt Length', 'jnews' ),
	'description'     => esc_html__( 'Set word length of excerpt on post.', 'jnews' ),
	'choices'         => [
		'min'  => '0',
		'max'  => '200',
		'step' => '1',
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_content_excerpt' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_date',
	'transport'       => 'postMessage',
	'default'         => 'default',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Content Date Format', 'jnews' ),
	'description'     => esc_html__( 'Choose which date format of the content you want to use for category.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_content_date' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_date_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Date Format for Content', 'jnews' ),
	'description'     => wp_kses( sprintf( __( "Please set custom date format for content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
		wp_kses_allowed_html() ),
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'partial_refresh' => [
		'jnews_category_content_date_custom' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_content_date',
			'operator' => '==',
			'value'    => 'custom',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_pagination',
	'transport'       => 'postMessage',
	'default'         => 'nav_1',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Choose Pagination Mode', 'jnews' ),
	'description'     => esc_html__( 'Choose which pagination mode that fit with your block.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'nav_1'      => esc_attr__( 'Normal - Navigation 1', 'jnews' ),
		'nav_2'      => esc_attr__( 'Normal - Navigation 2', 'jnews' ),
		'nav_3'      => esc_attr__( 'Normal - Navigation 3', 'jnews' ),
		'nextprev'   => esc_attr__( 'Ajax - Next Prev', 'jnews' ),
		'loadmore'   => esc_attr__( 'Ajax - Load More', 'jnews' ),
		'scrollload' => esc_attr__( 'Ajax - Auto Scroll Load', 'jnews' ),
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
	],
	'partial_refresh' => [
		'jnews_category_content_pagination' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_pagination_limit',
	'transport'       => 'postMessage',
	'default'         => 0,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Auto Load Limit', 'jnews' ),
	'description'     => esc_html__( 'Limit of auto load when scrolling, set to zero to always load until end of content.', 'jnews' ),
	'choices'         => [
		'min'  => 0,
		'max'  => 9999,
		'step' => 1,
	],
	'partial_refresh' => [
		'jnews_category_content_pagination_limit' => [
			'selector'        => '.jnews_category_content_wrapper',
			'render_callback' => function () {
				$single = new \JNews\Category\Category();
				echo jnews_sanitize_output( $single->render_content() );
			},
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_content_pagination',
			'operator' => '==',
			'value'    => 'scrollload',
		],
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
];


$options[] = [
	'id'              => 'jnews_category_content_pagination_align',
	'transport'       => 'postMessage',
	'default'         => 'center',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Pagination Align', 'jnews' ),
	'description'     => esc_html__( 'Choose pagination alignment.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'left'   => esc_attr__( 'Left', 'jnews' ),
		'center' => esc_attr__( 'Center', 'jnews' ),
	],
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_content_pagination',
			'operator' => 'in',
			'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
		],
	],
	'output'          => [
		[
			'method'   => 'class-masking',
			'element'  => '.jeg_navigation.jeg_pagination ',
			'property' => [
				'left'   => 'jeg_alignleft',
				'center' => 'jeg_aligncenter',
			],
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_pagination_show_navtext',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Navigation Text', 'jnews' ),
	'description'     => esc_html__( 'Show navigation text (next, prev).', 'jnews' ),
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_content_pagination',
			'operator' => 'in',
			'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
		],
	],
	'output'          => [
		[
			'method'   => 'remove-class',
			'element'  => '.jeg_navigation.jeg_pagination ',
			'property' => 'no_navtext',
		],
	],
];

$options[] = [
	'id'              => 'jnews_category_content_pagination_show_pageinfo',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Page Info', 'jnews' ),
	'description'     => esc_html__( 'Show page info text (Page x of y).', 'jnews' ),
	'postvar'         => [
		[
			'redirect' => 'category_tag',
			'refresh'  => false,
		],
	],
	'active_callback' => [
		[
			'setting'  => 'jnews_category_page_layout',
			'operator' => '!=',
			'value'    => 'custom-template',
		],
		[
			'setting'  => 'jnews_category_content_pagination',
			'operator' => 'in',
			'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
		],
	],
	'output'          => [
		[
			'method'   => 'remove-class',
			'element'  => '.jeg_navigation.jeg_pagination ',
			'property' => 'no_pageinfo',
		],
	],
];

return apply_filters( 'jnews_custom_customizer_option', $options, 'jnews_category_', null );
