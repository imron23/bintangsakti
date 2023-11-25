<?php

function single_category_option( $category_id ) {

	global $jnews_get_all_custom_archive_template;

	$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

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

	$overwrite_callback = [
		'setting'  => 'jnews_category_override_' . $category_id,
		'operator' => '==',
		'value'    => true,
	];

	$category      = get_category( $category_id );
	$category_slug = $category->slug;

	$options[] = [
		'id'          => 'jnews_category_override_color_' . $category_id,
		'transport'   => 'postMessage',
		'default'     => false,
		'type'        => 'jnews-toggle',
		'label'       => esc_html__( 'Override Color', 'jnews' ),
		'description' => esc_html__( 'Switch this option ON to customize this category color.', 'jnews' ),
	];

	$options[] = [
		'id'              => 'jnews_category_color_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '',
		'type'            => 'jnews-color',
		'label'           => esc_html__( 'Category Background Color', 'jnews' ),
		'description'     => esc_html__( 'Main color for this category.', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_override_color_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
		'output'          => [
			[
				'method'   => 'inject-style',
				'element'  => ".jeg_heroblock .jeg_post_category a.category-{$category_slug},.jeg_thumb .jeg_post_category a.category-{$category_slug},.jeg_pl_lg_box .jeg_post_category a.category-{$category_slug},.jeg_pl_md_box .jeg_post_category a.category-{$category_slug},.jeg_postblock_carousel_2 .jeg_post_category a.category-{$category_slug},.jeg_slide_caption .jeg_post_category a.category-{$category_slug}",
				'property' => 'background-color',
			],
			[
				'method'   => 'inject-style',
				'element'  => ".jeg_heroblock .jeg_post_category a.category-{$category_slug},.jeg_thumb .jeg_post_category a.category-{$category_slug},.jeg_pl_lg_box .jeg_post_category a.category-{$category_slug},.jeg_pl_md_box .jeg_post_category a.category-{$category_slug},.jeg_postblock_carousel_2 .jeg_post_category a.category-{$category_slug},.jeg_slide_caption .jeg_post_category a.category-{$category_slug}",
				'property' => 'border-color',
			],
		],
		'postvar'         => [
			[
				'refresh' => false,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_text_color_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '',
		'type'            => 'jnews-color',
		'label'           => esc_html__( 'Text Color', 'jnews' ),
		'description'     => esc_html__( 'Choose text color for this category.', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_override_color_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
		'output'          => [
			[
				'method'   => 'inject-style',
				'element'  => ".jeg_heroblock .jeg_post_category a.category-{$category_slug},.jeg_thumb .jeg_post_category a.category-{$category_slug},.jeg_pl_lg_box .jeg_post_category a.category-{$category_slug},.jeg_pl_md_box .jeg_post_category a.category-{$category_slug},.jeg_postblock_carousel_2 .jeg_post_category a.category-{$category_slug},.jeg_slide_caption .jeg_post_category a.category-{$category_slug}",
				'property' => 'color',
			],
		],
		'postvar'         => [
			[
				'refresh' => false,
			],
		],
	];

	$options[] = [
		'id'          => 'jnews_category_override_' . $category_id,
		'transport'   => 'postMessage',
		'default'     => false,
		'type'        => 'jnews-toggle',
		'label'       => esc_html__( 'Override This Category Setting', 'jnews' ),
		'description' => esc_html__( 'Override category setting.', 'jnews' ),
		'postvar'     => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
	];


	// sidebar section
	$options[] = [
		'id'              => 'jnews_category_sidebar_section_' . $category_id,
		'type'            => 'jnews-header',
		'label'           => esc_html__( 'Category Page Layout', 'jnews' ),
		'active_callback' => [ $overwrite_callback ],
	];

	$options[] = [
		'id'              => 'jnews_category_page_layout_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'right-sidebar',
		'type'            => 'jnews-radio-image',
		'label'           => esc_html__( 'Page Layout', 'jnews' ),
		'description'     => esc_html__( 'Choose your page layout.', 'jnews' ),
		'choices'         => [
			'right-sidebar'        => '',
			'left-sidebar'         => '',
			'right-sidebar-narrow' => '',
			'left-sidebar-narrow'  => '',
			'double-sidebar'       => '',
			'double-right-sidebar' => '',
			'no-sidebar'           => '',
			'custom-template'      => '',
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
		'active_callback' => [ $overwrite_callback ],
	];

	$options[] = [
		'id'              => 'jnews_category_custom_template_id_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Category Page Template List', 'jnews' ),
		'description'     => wp_kses( sprintf( __( 'Create custom category page template from <a href="%s" target="_blank">here</a>', 'jnews' ), get_admin_url() . 'edit.php?post_type=archive-template' ), wp_kses_allowed_html() ),
		'choices'         => $jnews_get_all_custom_archive_template,
		'active_callback' => [
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '==',
				'value'    => 'custom-template',
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_custom_template_number_post_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 10,
		'type'            => 'jnews-text',
		'label'           => esc_html__( 'Number of Post', 'jnews' ),
		'description'     => esc_html__( 'Set the number of post per page on category page.', 'jnews' ),
		'active_callback' => [
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '==',
				'value'    => 'custom-template',
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_sidebar_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'default-sidebar',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Category Sidebar', 'jnews' ),
		'description'     => wp_kses( __( "Choose your category sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews' ), wp_kses_allowed_html() ),
		'multiple'        => 1,
		'choices'         => $all_sidebar,
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'no-sidebar',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_second_sidebar_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'default-sidebar',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Second Category Sidebar', 'jnews' ),
		'description'     => wp_kses( __( "Choose your second sidebar for category page. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews' ), wp_kses_allowed_html() ),
		'multiple'        => 1,
		'choices'         => $all_sidebar,
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => 'in',
				'value'    => [ 'double-sidebar', 'double-right-sidebar' ],
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_sticky_sidebar_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => true,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Category Sticky Sidebar', 'jnews' ),
		'description'     => esc_html__( 'Enable sticky sidebar on this category page.', 'jnews' ),
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => true,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'no-sidebar',
			],
			$overwrite_callback,
		],
	];

	// header
	$options[] = [
		'id'              => 'jnews_category_header_section_' . $category_id,
		'type'            => 'jnews-header',
		'label'           => esc_html__( 'Category Header', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_header_' . $category_id,
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
		'partial_refresh' => [
			'jnews_category_header_top_' . $category_id    => [
				'selector'        => '.jnews_category_header_top',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_header( 'top' ) );
				},
			],
			'jnews_category_header_bottom_' . $category_id => [
				'selector'        => '.jnews_category_header_bottom',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_header( 'bottom' ) );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_header_style_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'dark',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Color Scheme', 'jnews' ),
		'description'     => esc_html__( 'Choose color for your category title background color.', 'jnews' ),
		'multiple'        => 1,
		'choices'         => [
			'normal' => esc_attr__( 'Normal Style (Light)', 'jnews' ),
			'dark'   => esc_attr__( 'Dark Style', 'jnews' ),
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_header_' . $category_id,
				'operator' => 'in',
				'value'    => [ '3', '4' ],
			],
			$overwrite_callback,
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
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_header_bg_color_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '#f5f5f5',
		'type'            => 'jnews-color',
		'label'           => esc_html__( 'Title Background Color', 'jnews' ),
		'description'     => esc_html__( 'Choose color for your category title background color.', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_header_' . $category_id,
				'operator' => 'in',
				'value'    => [ '3', '4' ],
			],
			$overwrite_callback,
		],
		'output'          => [
			[
				'method'   => 'inline-css',
				'element'  => ".category-{$category_id} .jeg_cat_bg",
				'property' => 'background-color',
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_header_bg_image_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '',
		'type'            => 'jnews-image',
		'label'           => esc_html__( 'Title Background Image', 'jnews' ),
		'description'     => esc_html__( 'Choose or upload image for your category background.', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_header_' . $category_id,
				'operator' => 'in',
				'value'    => [ '3', '4' ],
			],
			$overwrite_callback,
		],
		'output'          => [
			[
				'method'   => 'inline-css',
				'element'  => ".category-{$category_id} .jeg_cat_bg",
				'property' => 'background-image',
				'prefix'   => 'url("',
				'suffix'   => '")',
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
	];


	// hero type
	$options[] = [
		'id'              => 'jnews_category_hero_section_' . $category_id,
		'type'            => 'jnews-header',
		'label'           => esc_html__( 'Category Hero', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_show_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => true,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Category Hero Block', 'jnews' ),
		'description'     => esc_html__( 'Disable this option to hide category hero block.', 'jnews' ),
		'partial_refresh' => [
			'jnews_category_hero_show_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_' . $category_id,
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
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'partial_refresh' => [
			'jnews_category_hero_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_hero_show_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_style_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'jeg_hero_style_1',
		'type'            => 'jnews-radio-image',
		'label'           => esc_html__( 'Category Header Style', 'jnews' ),
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
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'partial_refresh' => [
			'jnews_category_hero_style_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_hero_show_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_margin_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 10,
		'type'            => 'jnews-number',
		'label'           => esc_html__( 'Hero Margin', 'jnews' ),
		'description'     => esc_html__( 'Margin of each hero element.', 'jnews' ),
		'choices'         => [
			'min'  => '0',
			'max'  => '30',
			'step' => '1',
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'partial_refresh' => [
			'jnews_category_hero_margin_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_hero_show_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_date_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'default',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Choose Date Format', 'jnews' ),
		'description'     => esc_html__( 'Choose which date format you want to use for category.', 'jnews' ),
		'multiple'        => 1,
		'choices'         => [
			'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
			'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
			'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'partial_refresh' => [
			'jnews_category_hero_date_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_hero_show_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_hero_date_custom_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'Y/m/d',
		'type'            => 'jnews-text',
		'label'           => esc_html__( 'Custom Date Format', 'jnews' ),
		'description'     => wp_kses( sprintf( __( "Please set custom date format for hero element. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
			wp_kses_allowed_html() ),
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'partial_refresh' => [
			'jnews_category_hero_date_custom_' . $category_id => [
				'selector'        => '.jnews_category_hero_container',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_hero() );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_hero_date_' . $category_id,
				'operator' => '==',
				'value'    => 'custom',
			],
			[
				'setting'  => 'jnews_category_hero_show_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
			$overwrite_callback,
		],
	];


	// content type
	$options[] = [
		'id'              => 'jnews_category_content_section_' . $category_id,
		'type'            => 'jnews-header',
		'label'           => esc_html__( 'Category Content', 'jnews' ),
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => '3',
		'type'            => 'jnews-radio-image',
		'label'           => esc_html__( 'Category Content Layout', 'jnews' ),
		'description'     => esc_html__( 'Choose your category content layout.', 'jnews' ),
		'multiple'        => 1,
		'choices'         => $content_layout,
		'partial_refresh' => [
			'jnews_category_content_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_boxed_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => false,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Enable Boxed', 'jnews' ),
		'description'     => esc_html__( 'This option will turn the module into boxed.', 'jnews' ),
		'partial_refresh' => [
			'jnews_category_boxed_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$category = new \JNews\Category\Category();
					echo jnews_sanitize_output( $category->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_content_' . $category_id,
				'operator' => 'in',
				'value'    => [ '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ],
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_boxed_shadow_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => false,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Enable Shadow', 'jnews' ),
		'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews' ),
		'partial_refresh' => [
			'jnews_category_boxed_shadow_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$category = new \JNews\Category\Category();
					echo jnews_sanitize_output( $category->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_content_' . $category_id,
				'operator' => 'in',
				'value'    => [ '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ],
			],
			[
				'setting'  => 'jnews_category_boxed_' . $category_id,
				'operator' => '==',
				'value'    => true,
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_box_shadow_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => false,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Enable Shadow', 'jnews' ),
		'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews' ),
		'partial_refresh' => [
			'jnews_category_box_shadow_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$category = new \JNews\Category\Category();
					echo jnews_sanitize_output( $category->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
			[
				'setting'  => 'jnews_category_content_' . $category_id,
				'operator' => 'in',
				'value'    => [ '37', '35', '33', '36', '32', '38' ],
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_excerpt_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 20,
		'type'            => 'jnews-number',
		'label'           => esc_html__( 'Excerpt Length', 'jnews' ),
		'description'     => esc_html__( 'Set the word length of excerpt on post.', 'jnews' ),
		'choices'         => [
			'min'  => '0',
			'max'  => '200',
			'step' => '1',
		],
		'partial_refresh' => [
			'jnews_category_content_excerpt_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_date_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'default',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Choose Date Format for Content', 'jnews' ),
		'description'     => esc_html__( 'Choose which date format of the content you want to use for category.', 'jnews' ),
		'multiple'        => 1,
		'choices'         => [
			'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
			'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
			'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
		],
		'partial_refresh' => [
			'jnews_category_content_date_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_date_custom_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => 'Y/m/d',
		'type'            => 'jnews-text',
		'label'           => esc_html__( 'Custom Date Format for Content', 'jnews' ),
		'description'     => wp_kses( sprintf( __( "Please set custom date format for post content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
			wp_kses_allowed_html() ),
		'partial_refresh' => [
			'jnews_category_content_date_custom_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_content_date_' . $category_id,
				'operator' => '==',
				'value'    => 'custom',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_pagination_' . $category_id,
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
		'partial_refresh' => [
			'jnews_category_content_pagination_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_pagination_limit_' . $category_id,
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
			'jnews_category_content_pagination_limit_' . $category_id => [
				'selector'        => '.jnews_category_content_wrapper',
				'render_callback' => function () {
					$single = new \JNews\Category\Category();
					echo jnews_sanitize_output( $single->render_content() );
				},
			],
		],
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_content_pagination_' . $category_id,
				'operator' => '==',
				'value'    => 'scrollload',
			],
			$overwrite_callback,
		],
	];


	$options[] = [
		'id'              => 'jnews_category_content_pagination_align_' . $category_id,
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
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'output'          => [
			[
				'method'   => 'class-masking',
				'element'  => ".category-{$category_id} .jeg_navigation.jeg_pagination",
				'property' => [
					'left'   => 'jeg_alignleft',
					'center' => 'jeg_aligncenter',
				],
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_content_pagination_' . $category_id,
				'operator' => 'in',
				'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
			],
			$overwrite_callback,
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_pagination_show_navtext_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => false,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Navigation Text', 'jnews' ),
		'description'     => esc_html__( 'Show navigation text (next, prev).', 'jnews' ),
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_content_pagination_' . $category_id,
				'operator' => 'in',
				'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
			],
			$overwrite_callback,
		],
		'output'          => [
			[
				'method'   => 'remove-class',
				'element'  => ".category-{$category_id} .jeg_navigation.jeg_pagination",
				'property' => 'no_navtext',
			],
		],
	];

	$options[] = [
		'id'              => 'jnews_category_content_pagination_show_pageinfo_' . $category_id,
		'transport'       => 'postMessage',
		'default'         => false,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Page Info', 'jnews' ),
		'description'     => esc_html__( 'Show page info text (Page x of y).', 'jnews' ),
		'postvar'         => [
			[
				'redirect' => 'category_tag_' . $category_id,
				'refresh'  => false,
			],
		],
		'active_callback' => [
			[
				'setting'  => 'jnews_category_page_layout_' . $category_id,
				'operator' => '!=',
				'value'    => 'custom-template',
			],
			[
				'setting'  => 'jnews_category_content_pagination_' . $category_id,
				'operator' => 'in',
				'value'    => [ 'nav_1', 'nav_2', 'nav_3' ],
			],
			$overwrite_callback,
		],
		'output'          => [
			[
				'method'   => 'remove-class',
				'element'  => ".category-{$category_id} .jeg_navigation.jeg_pagination",
				'property' => 'no_pageinfo',
			],
		],
	];

	return apply_filters( 'jnews_custom_customizer_option', $options, 'jnews_category_', '_' . $category_id );
}
