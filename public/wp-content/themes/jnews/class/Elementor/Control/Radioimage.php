<?php

namespace JNews\Elementor\Control;

use Elementor\Base_Data_Control;

class Radioimage extends Base_Data_Control {
	/**
	 * Get choose control type.
	 *
	 * Retrieve the control type, in this case `choose`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'jnews-radioimage';
	}

    public function enqueue()
    {
        wp_register_script('jnews-radioimage-control', get_parent_theme_file_uri( '/assets/js/admin/jnews-elementor-radioimage.js' ));
        wp_enqueue_script('jnews-radioimage-control');
    }


	/**
	 * Render choose control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid_input_type = '{{value}}';
		?>
		<div class="jnews-radioimage elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-choices">
					<# _.each( data.options, function( options, value ) { #>
					<input id="<?php $this->print_control_uid( $control_uid_input_type ); ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}">
					<label class="elementor-choices-label elementor-control-unit-1 tooltip-target" for="<?php $this->print_control_uid( $control_uid_input_type ); ?>" data-tooltip="{{ options.title }}" title="{{ options.title }}">
						<i class="{{ options.icon }}" aria-hidden="true"></i>
						<span class="elementor-screen-only">{{{ options.title }}}</span>
					</label>
					<# } ); #>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="jnews-radioimage elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Get choose control default settings.
	 *
	 * Retrieve the default settings of the choose control. Used to return the
	 * default settings while initializing the choose control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options' => [],
			'toggle' => true,
		];
	}
}
