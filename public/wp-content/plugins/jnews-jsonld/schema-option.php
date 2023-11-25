<?php

$options   = array();
$options[] = array(
	'id'          => 'jnews_option[enable_schema]',
	'option_type' => 'option',
	'transport'   => 'postMessage',
	'default'     => true,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Enable JSON LD Schema', 'jnews-jsonld' ),
	'description' => esc_html__( 'Turn this option on to enable JNews generate JSON LD Schema for your website.', 'jnews-jsonld' ),
);

return $options;
