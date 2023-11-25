<?php
/**
 * @author : Jegtheme
 */

class JNews_Footer_Instagram_Option extends \JNews\Module\ModuleOptionAbstract {

	public function compatible_column() {
		return array( 8, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'JNews - Horizontal Instagram', 'jnews-instagram' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Footer', 'jnews-instagram' );
	}

	public function set_options() {

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'footer_instagram_row',
			'heading'     => esc_html__( 'Number Of Rows', 'jnews-instagram' ),
			'description' => esc_html__( 'Number of rows for footer Instagram feed.', 'jnews-instagram' ),
			'min'         => 1,
			'max'         => 2,
			'step'        => 1,
			'std'         => 1,
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'footer_instagram_column',
			'heading'     => esc_html__( 'Number Of Columns', 'jnews-instagram' ),
			'description' => esc_html__( 'Number of Instagram feed columns.', 'jnews-instagram' ),
			'min'         => 5,
			'max'         => 10,
			'step'        => 1,
			'std'         => 8,
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'footer_instagram_video',
			'heading'     => esc_html__( 'Video Post Option', 'jnews-instagram' ),
			'description' => esc_html__( 'Display Instagram video post option as thumbnail or video.', 'jnews-instagram' ),
			'std'         => 'thumbnail',
			'value'       => array(
				esc_attr__( 'Thumbnail', 'jnews-instagram' ) => 'thumbnail',
				esc_attr__( 'Video', 'jnews-instagram' ) => 'video',
			),
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'footer_instagram_sort_type',
			'heading'     => esc_html__( 'Sort Feed Type', 'jnews-instagram' ),
			'description' => esc_html__( 'Sort the Instagram feed in a set order.', 'jnews-instagram' ),
			'std'         => 'most_recent',
			'value'       => array(
				esc_attr__( 'Most Recent', 'jnews-instagram' ) => 'most_recent',
				esc_attr__( 'Least Recent', 'jnews-instagram' ) => 'least_recent',
			),
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'footer_instagram_hover_style',
			'heading'     => esc_html__( 'Hover Style', 'jnews-instagram' ),
			'description' => esc_html__( 'Choose hover effect style.', 'jnews-instagram' ),
			'std'         => 'zoom',
			'value'       => array(
				esc_attr__( 'Normal', 'jnews-instagram' ) => 'normal',
				esc_attr__( 'Show Icon', 'jnews-instagram' ) => 'icon',
				esc_attr__( 'Show Like Count (Deprecated)', 'jnews-instagram' ) => 'like', //see (#7rxYcmJt)
				esc_attr__( 'Show Comment Count (Deprecated)', 'jnews-instagram' ) => 'comment', //see (#7rxYcmJt)
				esc_attr__( 'Zoom', 'jnews-instagram' )   => 'zoom',
				esc_html__( 'Zoom Rotate', 'jnews-instagram' ) => 'zoom-rotate',
				esc_attr__( 'No Effect', 'jnews-instagram' ) => ' ',
			),
		);

		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'footer_instagram_follow_button',
			'heading'     => esc_html__( 'Follow Button Text', 'jnews-instagram' ),
			'description' => esc_html__( 'Leave empty if you wont show it', 'jnews-instagram' ),
		);

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'footer_instagram_newtab',
			'heading'     => esc_html__( 'Open New Tab', 'jnews-instagram' ),
			'description' => esc_html__( 'Open Instagram profile page on new tab.', 'jnews-instagram' ),
		);
	}
}
