<?php

$instagram_token       = get_option( 'jnews_option[jnews_instagram]', array() );
$instagram_label       = esc_html__( 'Connect Instagram Account', 'jnews-instagram' );
$instagram_description = sprintf( __( 'Connect your Instagram account by clicking this <a class="%1$s" href="%2$s" target="_blank">link</a> and refer to next page URL.', 'jnews-instagram' ), 'jnews_instagram_access_token instagram', get_admin_url() . 'widgets.php' );
if ( is_array( $instagram_token ) && ! empty( $instagram_token ) ) {
	$instagram_label       = sprintf( __( 'Connected as %s', 'jnews-instagram' ), $instagram_token['username'] );
	$instagram_description = sprintf( __( 'This token is valid until %1$s. Connect another account by clicking this <a class="%2$s" href="%3$s" target="_blank">link</a>.', 'jnews-instagram' ), date( 'F d, Y H:i:s', (int) $instagram_token['expires_on'] ), 'jnews_instagram_access_token instagram', get_admin_url() . 'widgets.php' );
}

$options                      = array();
$cache_instagram_feed_refresh = array(
	'selector'        => '',
	'render_callback' => function () {
		do_action( 'jnews_purge_instagram_feed_cache' );
	},
);

$instagram_feed_show_active_callback = array(
	'setting'  => 'jnews_option[instagram_feed_enable]',
	'operator' => '!=',
	'value'    => 'hide',
);

$header_instagram_feed_refresh = array(
	'selector'        => '.jeg_header_instagram_wrapper',
	'render_callback' => function () {
		do_action( 'jnews_render_instagram_feed_header' );
	},
);

$footer_instagram_feed_refresh = array(
	'selector'        => '.jeg_footer_instagram_wrapper',
	'render_callback' => function () {
		do_action( 'jnews_render_instagram_feed_footer' );
	},
);

$options[] = array(
	'id'      => 'jnews_instagram_setting_section',
	'type'    => 'jnews-header',
	'section' => 'jnews_instagram_setting_section',
	'label'   => esc_html__( 'Instagram Setting', 'jnews' ),
);

$instagram_api = \JNEWS_INSTAGRAM\API\Instagram_Api::get_instance();
if ( $instagram_api->is_sb_activate() ) {
	$options[] = array(
		'id'          => 'jnews_instagram_plugin_alert',
		'type'        => 'jnews-alert',
		'default'     => 'alert',
		'section'     => 'jnews_instagram_setting_section',
		'label'       => esc_html__( 'Warning', 'jnews-instagram' ),
		'description' => esc_html__( 'JNews Instagram plugin can\'t be used while the Smash Balloon Instagram Feed plugin is active.', 'jnews-instagram' ),
	);
}

$options[] = array(
	'id'          => 'jnews_instagram_alert',
	'type'        => 'jnews-alert',
	'default'     => 'info',
	'section'     => 'jnews_instagram_setting_section',
	'label'       => $instagram_label,
	'description' => $instagram_description,
);

$options[] = array(
	'id'          => 'jnews_instagram_cache',
	'type'        => 'jnews-alert',
	'default'     => 'info',
	'section'     => 'jnews_instagram_setting_section',
	'label'       => 'Purge cache',
	'description' => 'Click <a class="jnews_instagram_purge_cache" href="#">here</a> to purge Instagram cache.',
);

$options[] = array(
	'id'      => 'jnews_instagram_feed_section',
	'type'    => 'jnews-header',
	'section' => 'jnews_instagram_feed_section',
	'label'   => esc_html__( 'Instagram Feed', 'jnews' ),
);

$options[] = array(
	'id'          => 'jnews_footer_instagram_alert',
	'type'        => 'jnews-alert',
	'default'     => 'info',
	'section'     => 'jnews_instagram_feed_section',
	'label'       => esc_html__( 'Footer Instagram Compatibility', 'jnews-instagram' ),
	'description' => wp_kses( __( 'Footer Instagram only compatible with <strong>Footer Type 5</strong> and <strong>Footer Type 6</strong>.', 'jnews-instagram' ), wp_kses_allowed_html() ),
);

$options[] = array(
	'id'              => 'jnews_option[instagram_feed_enable]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 'hide',
	'type'            => 'jnews-select',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Enable Instagram Feed', 'jnews-instagram' ),
	'description'     => esc_html__( 'Show the Instagram feed only on header, footer or both.', 'jnews-instagram' ),
	'multiple'        => 1,
	'choices'         => array(
		'only_header' => esc_attr__( 'Only Header', 'jnews-instagram' ),
		'only_footer' => esc_attr__( 'Only Footer', 'jnews-instagram' ),
		'both'        => esc_attr__( 'Header + Footer', 'jnews-instagram' ),
		'hide'        => esc_attr__( 'Hide ', 'jnews-instagram' ),
	),
	'partial_refresh' => array(
		'jnews_header_instagram_enable' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_enable' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_row]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 1,
	'type'            => 'jnews-slider',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Number Of Rows', 'jnews-instagram' ),
	'description'     => esc_html__( 'Number of rows for footer Instagram feed.', 'jnews-instagram' ),
	'choices'         => array(
		'min'  => '1',
		'max'  => '2',
		'step' => '1',
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_option[instagram_feed_enable]',
			'operator' => 'in',
			'value'    => array( 'only_footer', 'both' ),
		),
	),
	'partial_refresh' => array(
		'jnews_footer_instagram_row' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_column]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 8,
	'type'            => 'jnews-slider',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Number Of Columns', 'jnews-instagram' ),
	'description'     => esc_html__( 'Number of Instagram feed columns.', 'jnews-instagram' ),
	'choices'         => array(
		'min'  => '5',
		'max'  => '10',
		'step' => '1',
	),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_column' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_column' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_video]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 'thumbnail',
	'type'            => 'jnews-select',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Video Post Option', 'jnews-instagram' ),
	'description'     => esc_html__( 'Display Instagram video post option as thumbnail or video.', 'jnews-instagram' ),
	'multiple'        => 1,
	'choices'         => array(
		'thumbnail' => esc_attr__( 'Thumbnail', 'jnews-instagram' ),
		'video'     => esc_attr__( 'Video', 'jnews-instagram' ),
	),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_sort_type' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_sort_type' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_sort_type]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 'most_recent',
	'type'            => 'jnews-select',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Sort Feed Type', 'jnews-instagram' ),
	'description'     => esc_html__( 'Sort the Instagram feed in a set order.', 'jnews-instagram' ),
	'multiple'        => 1,
	'choices'         => array(
		'most_recent'  => esc_attr__( 'Most Recent', 'jnews-instagram' ),
		'least_recent' => esc_attr__( 'Least Recent', 'jnews-instagram' ),
	),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_sort_type' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_sort_type' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_hover_style]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => 'zoom',
	'type'            => 'jnews-select',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Hover Style', 'jnews-instagram' ),
	'description'     => esc_html__( 'Choose hover effect style.', 'jnews-instagram' ),
	'multiple'        => 1,
	'choices'         => array(
		'normal'      => esc_attr__( 'Normal', 'jnews-instagram' ),
		'icon'        => esc_attr__( 'Show Icon', 'jnews-instagram' ),
		'like'        => esc_attr__( 'Show Like Count (Deprecated)', 'jnews-instagram' ), //see (#7rxYcmJt)
		'comment'     => esc_attr__( 'Show Comment Count (Deprecated)', 'jnews-instagram' ), //see (#7rxYcmJt)
		'zoom'        => esc_attr__( 'Zoom', 'jnews-instagram' ),
		'zoom-rotate' => esc_html__( 'Zoom Rotate', 'jnews' ),
		' '           => esc_attr__( 'No Effect', 'jnews-instagram' ),
	),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_hover_style' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_hover_style' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_follow_button]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'type'            => 'jnews-text',
	'default'         => '',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Follow Button Text', 'jnews-instagram' ),
	'description'     => esc_html__( 'Leave empty if you wont show it.', 'jnews-instagram' ),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_follow_button' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_follow_button' => $footer_instagram_feed_refresh,
	),
);

$options[] = array(
	'id'              => 'jnews_option[footer_instagram_newtab]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'type'            => 'jnews-toggle',
	'section'         => 'jnews_instagram_feed_section',
	'label'           => esc_html__( 'Open New Tab', 'jnews-instagram' ),
	'description'     => esc_html__( 'Open Instagram profile page on new tab.', 'jnews-instagram' ),
	'active_callback' => array(
		$instagram_feed_show_active_callback,
	),
	'partial_refresh' => array(
		'jnews_header_instagram_newtab' => $header_instagram_feed_refresh,
		'jnews_footer_instagram_newtab' => $footer_instagram_feed_refresh,
	),
);

return $options;
