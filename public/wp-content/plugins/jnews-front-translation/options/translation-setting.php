<?php
/**
 * @see \JNews\Util\ValidateLicense::is_license_validated
 * @since 8.0.0
 */
if ( function_exists( 'jnews_is_active' ) && jnews_is_active()->is_license_validated() ) {
	return array(
		'title'    => esc_html( __( 'Translation Setting', 'jnews-front-translation' ) ),
		'name'     => 'translation_setting',
		'icon'     => 'font-awesome:fa-cog',
		'controls' => array(
			array(
				'type'        => 'toggle',
				'name'        => 'enable_translation',
				'label'       => esc_html( __( 'Enable Translation', 'jnews-front-translation' ) ),
				'description' => esc_html( __( 'Enable build in translation from JNews.', 'jnews-front-translation' ) ),
				'default'     => '1',
			),
		),
	);
} else {
	return array(
		'title'    => esc_html( __( 'Translation Setting', 'jnews-front-translation' ) ),
		'name'     => 'translation_setting',
		'icon'     => 'font-awesome:fa-cog',
		'controls' => array(
			array(
				'type'        => 'notebox',
				'name'        => 'activate_license',
				'status'      => 'error',
				'label'       => esc_html__( 'Activate License', 'jnews-front-translation' ),
				'description' => sprintf(
					wp_kses(
						__(
							'<span style="display: block;">Please activate your copy of JNews to unlock this feature. Click button bellow to activate:</span>
						<span class="jnews-notice-button">
							<a href="%s" class="button-primary jnews_customizer_activate_license">Activate Now</a>
						</span>',
							'jnews-front-translation'
						),
						array(
							'strong' => array(),
							'span'   => array(
								'style' => true,
								'class' => true,
							),
							'a'      => array(
								'href'  => true,
								'class' => true,
							),
						)
					),
					get_admin_url()
				),
			),
		),
	);
}
