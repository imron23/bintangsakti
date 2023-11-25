<?php
/**
 * @author : Jegtheme
 */

class JNews_Footer_Instagram_View extends \JNews\Module\ModuleViewAbstract {

	public function render_module( $attr, $column_class ) {

		$param = array(
			'row'    => $attr['footer_instagram_row'],
			'column' => $attr['footer_instagram_column'],
			'video'  => $attr['footer_instagram_video'],
			'sort'   => $attr['footer_instagram_sort_type'],
			'hover'  => $attr['footer_instagram_hover_style'],
			'newtab' => $attr['footer_instagram_newtab'] ? 'target=\'_blank\'' : '',
			'follow' => $attr['footer_instagram_follow_button'],
		);

		$instagram = new \JNEWS_INSTAGRAM\Instagram( $param );

		return $instagram->generate_element( false );
	}
}
