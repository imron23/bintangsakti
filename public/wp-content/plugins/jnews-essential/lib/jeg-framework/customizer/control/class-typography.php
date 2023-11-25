<?php
/**
 * Customizer Control: typography
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package jeg-framework
 */
namespace Jeg\Customizer\Control;

/**
 * Typography control.
 */
class Typography extends Control_Abstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jeg-typography';


	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$defaults = array(
			'font-family'      => false,
			'font-size'        => false,
			'font-size-unit'   => false,
			'variant'          => false,
			'line-height'      => false,
			'line-height-unit' => false,
			'letter-spacing'   => false,
			'color'            => false,
			'text-align'       => false,
			'text-transform'   => false,
			'show_variants'    => true,
			'show_subsets'     => true,
		);

		$this->json['default']       = wp_parse_args( $this->json['default'], $defaults );
		$this->json['show_variants'] = $this->json['default']['show_variants'];
		$this->json['show_subsets']  = $this->json['default']['show_subsets'];
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="wrapper">

			<# if ( false !== data.default['font-family'] ) { #>
				<# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
				<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
				<div class="font-family">
					<h5>Font Family</h5>
					<select id="jeg-typography-font-family-{{{ data.id }}}" placeholder="<?php echo esc_attr__( 'Select Font Family', 'jeg' ); ?>"></select>
				</div>
				<# if ( true === data.show_variants || false !== data.default.variant ) { #>
					<div class="variant hide-on-standard-fonts jeg-variant-wrapper">
						<h5>Font Variant</h5>
						<select class="variant" id="jeg-typography-variant-{{{ data.id }}}"></select>
					</div>
				<# } #>
				<# if ( true === data.show_subsets ) { #>
					<div class="subsets hide-on-standard-fonts jeg-subsets-wrapper">
						<h5>Font Subsets</h5>
						<select class="subset" id="jeg-typography-subsets-{{{ data.id }}}"></select>
					</div>
				<# } #>
			<# } #>

			<# if ( false !== data.default['font-size'] ) { #>
				<div class="font-size">
					<h5>Font Size</h5>
					<# if ( false !== data.default['font-size-unit'] ) { #>
						<div class="form-group">
							<input type="text" value="{{ data.value['font-size'] }}"/>
							<select id="jeg-typography-font-size-unit-{{{ data.id }}}">
								<option value="px"<# if ( 'px' === data.value['font-size-unit'] ) { #>selected<# } #>>PX</option>
								<option value="em"<# if ( 'em' === data.value['font-size-unit'] ) { #>selected<# } #>>EM</option>
								<option value="rem"<# if ( 'rem' === data.value['font-size-unit'] ) { #>selected<# } #>>REM</option>
								<option value="vw"<# if ( 'vw' === data.value['font-size-unit'] ) { #>selected<# } #>>VW</option>
							</select>
						</div>
					<# } else { #>
						<input type="text" value="{{ data.value['font-size'] }}"/>
					<# } #>
				</div>
			<# } #>

			<# if ( false !== data.default['line-height'] ) { #>
				<div class="line-height">
					<h5>Line Height</h5>
					<# if ( false !== data.default['line-height-unit'] ) { #>
						<div class="form-group">
							<input type="text" value="{{ data.value['line-height'] }}"/>
							<select id="jeg-typography-line-height-unit-{{{ data.id }}}">
								<option value="none"<# if ( 'none' === data.value['line-height-unit'] ) { #>selected<# } #>>-</option>
								<option value="px"<# if ( 'px' === data.value['line-height-unit'] ) { #>selected<# } #>>PX</option>
								<option value="em"<# if ( 'em' === data.value['line-height-unit'] ) { #>selected<# } #>>EM</option>
							</select>
						</div>
					<# } else { #>
						<input type="text" value="{{ data.value['line-height'] }}"/>
					<# } #>
				</div>
			<# } #>

			<# if ( false !== data.default['letter-spacing'] ) { #>
				<div class="letter-spacing">
					<h5>Letter Spacing</h5>
					<input type="text" value="{{ data.value['letter-spacing'] }}"/>
				</div>
			<# } #>

			<# if ( false !== data.default['text-align'] ) { #>
				<div class="text-align">
					<h5>Text Align</h5>
					<input type="radio" value="inherit" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-inherit" <# if ( data.value['text-align'] === 'inherit' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-inherit">
							<span class="dashicons dashicons-editor-removeformatting"></span>
							<span class="screen-reader-text">Inherit</span>
						</label>
					</input>
					<input type="radio" value="left" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-left" <# if ( data.value['text-align'] === 'left' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-left">
							<span class="dashicons dashicons-editor-alignleft"></span>
							<span class="screen-reader-text">Left</span>
						</label>
					</input>
					<input type="radio" value="center" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-center" <# if ( data.value['text-align'] === 'center' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-center">
							<span class="dashicons dashicons-editor-aligncenter"></span>
							<span class="screen-reader-text">Center</span>
						</label>
					</input>
					<input type="radio" value="right" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-right" <# if ( data.value['text-align'] === 'right' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-right">
							<span class="dashicons dashicons-editor-alignright"></span>
							<span class="screen-reader-text">Right</span>
						</label>
					</input>
					<input type="radio" value="justify" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-justify" <# if ( data.value['text-align'] === 'justify' ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}-text-align-justify">
							<span class="dashicons dashicons-editor-justify"></span>
							<span class="screen-reader-text">Justify</span>
						</label>
					</input>
				</div>
			<# } #>

			<# if ( false !== data.default['text-transform'] ) { #>
				<div class="text-transform">
					<h5>Transform</h5>
					<select id="jeg-typography-text-transform-{{{ data.id }}}">
						<option value="none"<# if ( 'none' === data.value['text-transform'] ) { #>selected<# } #>>None</option>
						<option value="capitalize"<# if ( 'capitalize' === data.value['text-transform'] ) { #>selected<# } #>>Capitalize</option>
						<option value="uppercase"<# if ( 'uppercase' === data.value['text-transform'] ) { #>selected<# } #>>Uppercase</option>
						<option value="lowercase"<# if ( 'lowercase' === data.value['text-transform'] ) { #>selected<# } #>>Lowercase</option>
						<option value="initial"<# if ( 'initial' === data.value['text-transform'] ) { #>selected<# } #>>Initial</option>
						<option value="inherit"<# if ( 'inherit' === data.value['text-transform'] ) { #>selected<# } #>>Inherit</option>
					</select>
				</div>
			<# } #>

			<# if ( false !== data.default['color'] ) { #>
				<div class="color">
					<h5>Color</h5>
					<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="jeg-color-control color-picker"/>
				</div>
			<# } #>
		</div>
		<?php
	}
}
