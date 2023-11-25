<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Block;

class Block_36_View extends BlockViewAbstract {

	public function render_block_type_1( $post, $image_size ) {
		$primary_category = $this->get_primary_category( $post->ID );
		$box_shadow_flag  = isset( $this->attribute['box_shadow'] ) && $this->attribute['box_shadow'] ? 'box_shadow' : '';

		if ( $this->is_thumbnail_landscape( $post->ID ) ) {
			$thumbnail = $this->get_thumbnail( $post->ID, $image_size );

			return '<article ' . jnews_post_class( 'jeg_post jeg_pl_md_5 ' . $box_shadow_flag, $post->ID ) . '>
						<div class="box_wrap">
							<div class="jeg_thumb">
								' . jnews_edit_post( $post->ID ) . '
								<a href="' . get_the_permalink( $post ) . '">' . $thumbnail . "</a>
								<div class=\"jeg_post_category\">
									<span>{$primary_category}</span>
								</div>
							</div>
							<div class=\"jeg_postblock_content\">
								<h3 class=\"jeg_post_title\">
									<a href=\"" . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a>
								</h3>
								' . $this->post_meta_3( $post ) . '
								<div class="jeg_post_excerpt">
									<p>' . $this->get_excerpt( $post ) . '</p>
								</div>
							</div>
						</div>
					</article>';
		}
		$thumb_id   = get_post_thumbnail_id( $post->ID );
		$thumb_data = wp_get_attachment_image_src( $thumb_id, 'full' );

		$style = "style='background-image: url({$thumb_data[0]})'";

		return '<article ' . jnews_post_class( 'jeg_post jeg_pl_md_box', $post->ID ) . ">
					<div class=\"box_wrap\">
						<span class=\"jeg_postformat_icon\"></span>
						<div class=\"jeg_thumb\" {$style}>
							" . jnews_edit_post( $post->ID, 'right' ) . "
							<div class=\"jeg_post_category\">
								<span>{$primary_category}</span>
							</div>
						</div>
						<div class=\"jeg_postblock_content\">
							<h3 class=\"jeg_post_title\">
								<a href=\"" . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a>
							</h3>
							<div class="jeg_post_excerpt">
								<p>' . $this->get_excerpt( $post ) . '</p>
							</div>
							' . $this->post_meta_1( $post ) . '
						</div>
					</div>
				</article>';
	}

	public function build_column_1( $results ) {
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-350x250' );
		}

		return "<div class=\"jeg_posts_wrap\">
					<div class=\"jeg_posts jeg_load_more_flag\"> 
						{$first_block}
					</div>
				</div>";
	}

	public function build_column_1_alt( $results ) {
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-350x250' );
		}

		return $first_block;
	}

	public function render_output( $attr, $column_class ) {
		$results    = isset( $attr['results'] ) ? $attr['results'] : $this->build_query( $attr );
		$navigation = $this->render_navigation( $attr, $results['next'], $results['prev'], $results['total_page'] );
		$content    = ! empty( $results['result'] ) ? $this->render_column( $results['result'], $column_class ) : $this->empty_content();

		return "<div class=\"jeg_block_container\">
					{$this->get_content_before($attr)}
					{$content}
					{$this->get_content_after($attr)}
				</div>
				<div class=\"jeg_block_navigation\">
					{$this->get_navigation_before($attr)}
					{$navigation}
					{$this->get_navigation_after($attr)}
				</div>";
	}

	public function render_column( $result, $column_class ) {
		return $this->build_column_1( $result );
	}

	public function render_column_alt( $result, $column_class ) {
		return $this->build_column_1_alt( $result );
	}

	public function is_thumbnail_landscape( $id ) {
		$thumb_id   = get_post_thumbnail_id( $id );
		$thumb_data = wp_get_attachment_image_src( $thumb_id, 'full' );
		return ( ( isset( $thumb_data[1] ) && isset( $thumb_data[2] ) ) && ( $thumb_data[1] < $thumb_data[2] ) ) ? false : true;
	}
}
