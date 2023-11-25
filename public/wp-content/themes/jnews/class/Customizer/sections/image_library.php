<?php

$options = [];

$options[] = [
	'id'          => 'jnews_share_library',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Share Library', 'jnews' ),
	'description' => esc_html__( 'Share image library across all users', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_capabilities_contributor_upload_library',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Allow contributor Upload Media Library', 'jnews' ),
	'description' => esc_html__( 'Allow contributor Role to Uplod into media library', 'jnews' ),
];

$options[] = [
	'id'          => 'jnews_capabilities_subscriber_upload_library',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Allow subscriber Upload Media Library', 'jnews' ),
	'description' => esc_html__( 'Allow Subscriber Role to Uplod into media library', 'jnews' ),
];

return $options;
