<?php

$options = [];

$options[] = [
	'id'              => 'jeg[jquery_option]',
	'option_type'     => 'option',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jeg-toggle',
	'section'         => 'jeg_framework_section',
	'label'           => esc_html__( 'Enable jQuery Migrate Option', 'jeg' ),
	'description'     => wp_kses( sprintf( __('This option serves as a temporary solution, enabling the migration script for your site to give your plugin and theme authors some more time to update, and test, their code.', 'jeg') ), wp_kses_allowed_html() ),
];

return $options;