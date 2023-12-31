<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleViewAbstract;

class Element_Socialiconwrapper_View extends ModuleViewAbstract {

	public function render_module( $attr, $column_class ) {
		global $social_inline_css, $social_vertical, $social_svg_css, $social_svg_class;
		$social_svg_class = 'jeg-icon-' . uniqid();
		$style            = isset( $attr['style'] ) ? $attr['style'] : '';
		$social_svg_css   = ! empty( $attr['icon_color'] ) ? '.socials_widget a .jeg-icon .' . $social_svg_class . ' svg{fill:' . $attr['icon_color'] . '!important;}' : '';
		$bg_color         = ( $attr['style'] != 'nobg' ) && ! empty( $attr['bg_color'] ) ? 'background-color:' . $attr['bg_color'] . ';' : '';
		$icon_color       = ! empty( $attr['icon_color'] ) ? 'color:' . $attr['icon_color'] . ';' : '';

		$social_inline_css = ! empty( $attr['bg_color'] ) || ! empty( $icon_color ) ? 'style="' . $bg_color . $icon_color . '"' : '';
		$social_vertical   = $attr['vertical'] ? 'vertical_social' : '';

		$align        = ! $social_vertical && $attr['align'] ? 'jeg_aligncenter' : '';
		$beforesocial = isset( $attr['beforesocial'] ) && ! empty( $attr['beforesocial'] ) ? wp_kses( $attr['beforesocial'], wp_kses_allowed_html() ) : '';
		$aftersocial  = isset( $attr['aftersocial'] ) && ! empty( $attr['aftersocial'] ) ? wp_kses( $attr['aftersocial'], wp_kses_allowed_html() ) : '';

		return "<div {$this->element_id($attr)} class='jeg_social_wrap " . esc_attr( $align ) . " {$attr['el_class']}'>
				{$beforesocial}
			    <div class='socials_widget {$social_vertical}  " . esc_attr( $style ) . "'>
				    " . ( function_exists( 'wpb_js_remove_wpautop' ) ? wpb_js_remove_wpautop( $this->content ) : do_shortcode( $this->content ) ) . "
			    </div>
			    {$aftersocial}
		    </div>";
	}
}
