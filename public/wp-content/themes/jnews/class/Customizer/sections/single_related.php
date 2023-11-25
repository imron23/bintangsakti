<?php

$post_related_partial_refresh = [
	'selector'        => '.jnews_related_post_container',
	'render_callback' => function () {
		$single = \JNews\Single\SinglePost::getInstance();
		$single->related_post();
	},
];

$related_active_callback = [
	'setting'  => 'jnews_single_show_post_related',
	'operator' => '==',
	'value'    => true,
];

$related_title_active_callback = [
	'setting'  => 'jnews_single_post_related_override_title',
	'operator' => '==',
	'value'    => true,
];

$single_post_tag = [
	'redirect' => 'single_post_tag',
	'refresh'  => false,
];


$inline_related_active_callback = [
	'setting'  => 'jnews_single_post_show_inline_related',
	'operator' => '==',
	'value'    => true,
];

$inline_post_related_partial_refresh = [
	'selector'        => '.jnews_inline_related_post_wrapper',
	'render_callback' => function () {
		$single = \JNews\Single\SinglePost::getInstance();
		echo jnews_sanitize_by_pass( $single->build_inline_related_post() );
	},
];

$inline_post_related_content_refresh = [
	'selector'        => '.content-inner',
	'render_callback' => function () {
		\JNews\Single\SinglePost::getInstance();
		$content_post = get_post( get_the_ID() );
		$content      = $content_post->post_content;
		$content      = apply_filters( 'the_content', $content );
		$content      = str_replace( ']]>', ']]&gt;', $content );
		echo jnews_sanitize_output( $content );
	},
];

$single_post_callback = [
	'setting'  => 'jnews_single_blog_template',
	'operator' => '!=',
	'value'    => 'custom',
];


$options = [];

$options[] = [
	'id'              => 'jnews_single_blog_post_related_header',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Single Bottom Related Post', 'jnews' ),
	'active_callback' => [
		$single_post_callback,
	],
];


$options[] = [
	'id'              => 'jnews_single_show_post_related',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Post Related', 'jnews' ),
	'description'     => esc_html__( 'Enable this option to show post related (below article).', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_show_post_related' => $post_related_partial_refresh,
	],
	'postvar'         => [ $single_post_tag ],
	'active_callback' => [
		$single_post_callback,
	],
];

$options[] = [
	'id'              => 'jnews_single_post_related_override_title',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jeg-toggle',
	'label'           => esc_html__( 'Override Header Text', 'jnews-paywall' ),
	'description'     => esc_html__( 'If enabled, this option will override header text above the related post view.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_show_post_related' => $post_related_partial_refresh,
	],
	'postvar'         => [ $single_post_tag ],
	'active_callback' => [
		$single_post_callback,
	],
];

$options[] = [
	'id'              => 'jnews_single_post_related_ftitle',
	'transport'       => 'postMessage',
	'default'         => 'Related',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'First Title', 'jnews' ),
	'description'     => esc_html__( 'First title of related post.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_related_ftitle' => $post_related_partial_refresh,
	],
	'active_callback' => [ $related_title_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_stitle',
	'transport'       => 'postMessage',
	'default'         => 'Posts',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Second Title', 'jnews' ),
	'description'     => esc_html__( 'Secondary title of related post.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_related_stitle' => $post_related_partial_refresh,
	],
	'active_callback' => [ $related_title_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_match',
	'transport'       => 'postMessage',
	'default'         => 'category',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Post Filter', 'jnews' ),
	'description'     => esc_html__( 'Select how related post will filter article.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'category' => esc_attr__( 'Category', 'jnews' ),
		'tag'      => esc_attr__( 'Tag', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_related_match' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_sort_by',
	'transport'       => 'postMessage',
	'default'         => 'latest',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Sort by', 'jnews' ),
	'description'     => wp_kses( __( "Sort post by this option<br/>* <strong>View Counter :</strong> Need <strong>JNews View Counter</strong> plugin enabled.<br/>* <strong>Jetpack :</strong> Need <strong>Jetpack</strong> plugin & Stat module enabled.<br/>* Like and share only count real like and share.", 'jnews' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => array(
		'latest' => esc_attr__( 'Latest Post - Published Date', 'jnews' ),
		'latest_modified' => esc_attr__( 'Latest Post - Modified Date', 'jnews' ),
		'oldest' => esc_attr__( 'Oldest Post - Published Date', 'jnews' ),
		'oldest_modified' => esc_attr__( 'Oldest Post - Modified Date', 'jnews' ),
		'alphabet_asc' => esc_attr__( 'Alphabet Asc', 'jnews' ),
		'alphabet_desc' => esc_attr__( 'Alphabet Desc', 'jnews' ),
		'random' => esc_attr__( 'Random Post', 'jnews' ),
		'most_comment' => esc_attr__( 'Most Comment', 'jnews' ),
		'popular_post' => esc_attr__( 'Popular Post (All Time - View Counter)', 'jnews' ),
	),
	'partial_refresh' => [
		'jnews_single_post_related_sort_by' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];


$options[] = [
	'id'              => 'jnews_single_post_related_header',
	'transport'       => 'refresh',
	'default'         => 'heading_6',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Related Post Module Header Style', 'jnews' ),
	'description'     => esc_html__( 'Choose header style for your related search.', 'jnews' ),
	'choices'         => [
		'heading_1' => '',
		'heading_2' => '',
		'heading_3' => '',
		'heading_4' => '',
		'heading_5' => '',
		'heading_6' => '',
		'heading_7' => '',
		'heading_8' => '',
		'heading_9' => '',
	],
	'partial_refresh' => [
		'jnews_single_post_related_header' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];


$options[] = [
	'id'              => 'jnews_single_post_pagination_related',
	'transport'       => 'postMessage',
	'default'         => 'nextprev',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Pagination Style', 'jnews' ),
	'description'     => esc_html__( 'Adjust how related post will shown.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'disable'    => esc_html__( 'No Pagination', 'jnews' ),
		'nextprev'   => esc_html__( 'Next Prev', 'jnews' ),
		'loadmore'   => esc_html__( 'Load More', 'jnews' ),
		'scrollload' => esc_html__( 'Auto Load on Scroll', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_pagination_related' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_number_post_related',
	'transport'       => 'postMessage',
	'default'         => 5,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Number of Post', 'jnews' ),
	'description'     => esc_html__( 'Set the number of post each related post load.', 'jnews' ),
	'choices'         => [
		'min'  => '2',
		'max'  => '10',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_single_number_post_related' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_unique_content',
	'transport'       => 'postMessage',
	'default'         => 'disable',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Include into Unique Content Group', 'jnews' ),
	'description'     => esc_html__( 'Choose unique content option, and this module will be included into unique content group. It won\'t duplicate content across the group. Ajax loaded content won\'t affect this unique content feature.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => array_flip(
		[
			esc_html__( 'Disable', 'jnews' )                  => 'disable',
			esc_html__( 'Unique Content - Group 1', 'jnews' ) => 'unique1',
			esc_html__( 'Unique Content - Group 2', 'jnews' ) => 'unique2',
			esc_html__( 'Unique Content - Group 3', 'jnews' ) => 'unique3',
			esc_html__( 'Unique Content - Group 4', 'jnews' ) => 'unique4',
			esc_html__( 'Unique Content - Group 5', 'jnews' ) => 'unique5',
		]
	),
	'partial_refresh' => [
		'jnews_single_post_related_unique_content' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_auto_load_related',
	'transport'       => 'postMessage',
	'default'         => 3,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Auto Load Limit', 'jnews' ),
	'description'     => esc_html__( 'Limit of auto load when scrolling, set to zero to always load until end of content.', 'jnews' ),
	'choices'         => [
		'min'  => '0',
		'max'  => '500',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_single_post_auto_load_related' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		[
			'setting'  => 'jnews_single_post_pagination_related',
			'operator' => '!=',
			'value'    => 'disable',
		],
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];


$options[] = [
	'id'              => 'jnews_single_post_related_template',
	'transport'       => 'postMessage',
	'default'         => '9',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Related PostTemplate', 'jnews' ),
	'description'     => esc_html__( 'Choose your related post template.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'1'  => '',
		'2'  => '',
		'3'  => '',
		'4'  => '',
		'5'  => '',
		'6'  => '',
		'7'  => '',
		'8'  => '',
		'9'  => '',
		'10' => '',
		'11' => '',
		'12' => '',
		'13' => '',
		'14' => '',
		'15' => '',
		'16' => '',
		'17' => '',
		'18' => '',
		'19' => '',
		'20' => '',
		'21' => '',
		'22' => '',
		'23' => '',
		'24' => '',
		'25' => '',
		'26' => '',
		'27' => '',
	],
	'partial_refresh' => [
		'jnews_single_post_related_template' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];


$options[] = [
	'id'              => 'jnews_single_post_related_excerpt',
	'transport'       => 'postMessage',
	'default'         => 20,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Excerpt Length', 'jnews' ),
	'description'     => esc_html__( 'Set word length of excerpt on related post.', 'jnews' ),
	'choices'         => [
		'min'  => '0',
		'max'  => '200',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_single_post_related_archive' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_date',
	'transport'       => 'postMessage',
	'default'         => 'default',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Post Date Format', 'jnews' ),
	'description'     => esc_html__( 'Choose which date format you want to use for archive content.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_related_date' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_related_date_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Date Format for Related Post', 'jnews' ),
	'description'     => wp_kses( sprintf( __( "Please set your date format for related post content, for more detail about this format, please refer to
                        <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
		wp_kses_allowed_html() ),
	'partial_refresh' => [
		'jnews_single_post_related_date_custom' => $post_related_partial_refresh,
	],
	'active_callback' => [
		$related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'    => 'jnews_single_post_inline_related_tab_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Single Inline Related Post', 'jnews' ),
];

$options[] = [
	'id'              => 'jnews_single_post_show_inline_related',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Inline Post Related', 'jnews' ),
	'description'     => esc_html__( 'Enable this option to show post related inside post content.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_show_inline_related' => $inline_post_related_content_refresh,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_ftitle',
	'transport'       => 'postMessage',
	'default'         => 'Related',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'First Title', 'jnews' ),
	'description'     => esc_html__( 'First title of inline related post.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_inline_related_ftitle' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_stitle',
	'transport'       => 'postMessage',
	'default'         => 'Posts',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Second Title', 'jnews' ),
	'description'     => esc_html__( 'Secondary title of inline related post.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_inline_related_stitle' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_fullwidth',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Fullwidth Related Post', 'jnews' ),
	'description'     => esc_html__( 'Enable this option to show post related with fullwidth size.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_inline_related_fullwidth' => $inline_post_related_content_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_float',
	'transport'       => 'postMessage',
	'default'         => 'left',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Post Float', 'jnews' ),
	'description'     => esc_html__( 'Select related post float position.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'left'  => esc_attr__( 'Left Side', 'jnews' ),
		'right' => esc_attr__( 'Right Side', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_float' => $inline_post_related_content_refresh,
	],
	'active_callback' => [
		$inline_related_active_callback,
		[
			'setting'  => 'jnews_single_post_inline_related_fullwidth',
			'operator' => '==',
			'value'    => false,
		],
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_paragraph',
	'transport'       => 'postMessage',
	'default'         => 2,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Show After Paragraph', 'jnews' ),
	'description'     => esc_html__( 'Set after which paragraph you want the inline related post to show.', 'jnews' ),
	'choices'         => [
		'min'  => '0',
		'max'  => '20',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_paragraph' => $inline_post_related_content_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_random',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Random Related Post Position', 'jnews' ),
	'description'     => esc_html__( 'Set random on which paragraph the inline related post will show.', 'jnews' ),
	'partial_refresh' => [
		'jnews_single_post_inline_related_random' => $inline_post_related_content_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_overflow',
	'transport'       => 'postMessage',
	'default'         => 'top',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Overflow Related Post Position', 'jnews' ),
	'description'     => esc_html__( 'Set which position the inline related post will show in case the number of paragraph is less than inline paragraph set', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'top'    => esc_attr__( 'Top', 'jnews' ),
		'bottom' => esc_attr__( 'Bottom', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_overflow' => $inline_post_related_content_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_match',
	'transport'       => 'postMessage',
	'default'         => 'category',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Post Filter', 'jnews' ),
	'description'     => esc_html__( 'Select how related post will filter article.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'category' => esc_attr__( 'Category', 'jnews' ),
		'tag'      => esc_attr__( 'Tag', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_match' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_sort_by',
	'transport'       => 'postMessage',
	'default'         => 'latest',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Sort by', 'jnews' ),
	'description'     => wp_kses( __( "Sort post by this option<br/>* <strong>View Counter :</strong> Need <strong>JNews View Counter</strong> plugin enabled.<br/>* <strong>Jetpack :</strong> Need <strong>Jetpack</strong> plugin & Stat module enabled.<br/>* Like and share only count real like and share.", 'jnews' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => array(
		'latest' => esc_attr__( 'Latest Post - Published Date', 'jnews' ),
		'latest_modified' => esc_attr__( 'Latest Post - Modified Date', 'jnews' ),
		'oldest' => esc_attr__( 'Oldest Post - Published Date', 'jnews' ),
		'oldest_modified' => esc_attr__( 'Oldest Post - Modified Date', 'jnews' ),
		'alphabet_asc' => esc_attr__( 'Alphabet Asc', 'jnews' ),
		'alphabet_desc' => esc_attr__( 'Alphabet Desc', 'jnews' ),
		'random' => esc_attr__( 'Random Post', 'jnews' ),
		'most_comment' => esc_attr__( 'Most Comment', 'jnews' ),
		'popular_post' => esc_attr__( 'Popular Post (All Time - View Counter)', 'jnews' ),
	),
	'partial_refresh' => [
		'jnews_single_post_inline_related_sort_by' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [
		$inline_related_active_callback,
		$single_post_callback,
	],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_header',
	'transport'       => 'postMessage',
	'default'         => 'heading_6',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Related Post Module Header Style', 'jnews' ),
	'description'     => esc_html__( 'Choose header style for your related search.', 'jnews' ),
	'choices'         => [
		'heading_1' => '',
		'heading_2' => '',
		'heading_3' => '',
		'heading_4' => '',
		'heading_5' => '',
		'heading_6' => '',
		'heading_7' => '',
		'heading_8' => '',
		'heading_9' => '',
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_header' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_pagination',
	'transport'       => 'postMessage',
	'default'         => 'nextprev',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Pagination Style', 'jnews' ),
	'description'     => esc_html__( 'Adjust how related post will shown.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'disable'  => esc_html__( 'No Pagination', 'jnews' ),
		'nextprev' => esc_html__( 'Next Prev', 'jnews' ),
		'loadmore' => esc_html__( 'Load More', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_pagination' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_number',
	'transport'       => 'postMessage',
	'default'         => 3,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Number of Post', 'jnews' ),
	'description'     => esc_html__( 'Set the number of post each related post load.', 'jnews' ),
	'choices'         => [
		'min'  => '2',
		'max'  => '10',
		'step' => '1',
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_number' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_unique_content',
	'transport'       => 'postMessage',
	'default'         => 'disable',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Include into Unique Content Group', 'jnews' ),
	'description'     => esc_html__( 'Choose unique content option, and this module will be included into unique content group. It won\'t duplicate content across the group. Ajax loaded content won\'t affect this unique content feature.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => array_flip(
		[
			esc_html__( 'Disable', 'jnews' )                  => 'disable',
			esc_html__( 'Unique Content - Group 1', 'jnews' ) => 'unique1',
			esc_html__( 'Unique Content - Group 2', 'jnews' ) => 'unique2',
			esc_html__( 'Unique Content - Group 3', 'jnews' ) => 'unique3',
			esc_html__( 'Unique Content - Group 4', 'jnews' ) => 'unique4',
			esc_html__( 'Unique Content - Group 5', 'jnews' ) => 'unique5',
		]
	),
	'partial_refresh' => [
		'jnews_single_post_inline_related_unique_content' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_template',
	'transport'       => 'postMessage',
	'default'         => '29',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Related PostTemplate', 'jnews' ),
	'description'     => esc_html__( 'Choose your related post template.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'20' => '',
		'21' => '',
		'28' => '',
		'29' => '',
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_template' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_date',
	'transport'       => 'postMessage',
	'default'         => 'default',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Related Post Date Format', 'jnews' ),
	'description'     => esc_html__( 'Choose which date format you want to use for archive content.', 'jnews' ),
	'multiple'        => 1,
	'choices'         => [
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews' ),
	],
	'partial_refresh' => [
		'jnews_single_post_inline_related_date' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

$options[] = [
	'id'              => 'jnews_single_post_inline_related_date_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Date Format for Related Post', 'jnews' ),
	'description'     => wp_kses( sprintf( __( "Please set your date format for related post content, for more detail about this format, please refer to
                        <a href='%s' target='_blank'>Developer Codex</a>.", "jnews" ), "https://developer.wordpress.org/reference/functions/current_time/" ),
		wp_kses_allowed_html() ),
	'partial_refresh' => [
		'jnews_single_post_inline_related_date_custom' => $inline_post_related_partial_refresh,
	],
	'active_callback' => [ $inline_related_active_callback ],
	'postvar'         => [ $single_post_tag ],
];

return $options;
