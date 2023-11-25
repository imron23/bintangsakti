<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Post;

use JNews\Module\Block\BlockViewAbstract;
use JNews\Single\SinglePost;

class Post_Related_View extends PostViewAbstract {

	public function render_module_back( $attr, $column_class ) {
		$attribute = array(
			'first_title'             => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_ftitle', 'Related' ) : jnews_return_translation( 'Related', 'jnews', 'related' ),
			'second_title'            => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_stitle', 'Posts' ) : jnews_return_translation( ' Posts', 'jnews', 'posts' ),
			'header_type'             => $attr['header_type'],
			'date_format'             => $attr['date'],
			'date_format_custom'      => $attr['date_custom'],
			'excerpt_length'          => $attr['excerpt'],
			'pagination_number_post'  => $attr['number'],
			'number_post'             => $attr['number'],
			'unique_content'          => $attr['unique_content'],
			'include_category'        => '',
			'include_tag'             => '',
			'sort_by'                 => $attr['sort_by'],
			'pagination_mode'         => $attr['pagination'],
			'pagination_scroll_limit' => $attr['auto_load'],
			'paged'                   => 1,
			'column_width'            => $attr['column_width'], //see TtGCsH5v
		);

		$name = 'JNews_Block_' . str_replace( 'template_', '', $attr['template'] );
		$name = jnews_get_view_class_from_shortcode( $name );

		/** @var $content_instance BlockViewAbstract */
		$content_instance = jnews_get_module_instance( $name );
		$result           = $content_instance->build_module( $attribute );

		return "<div {$this->element_id($attr)} class='jeg_custom_related_wrapper {$attr['scheme']} {$attr['el_class']} {$this->get_vc_class_name()}'>" .
				$result .
			'</div>';
	}

	public function render_module_front( $attr, $column_class ) {
		$match    = $attr['match'];
		$category = $tag = $result = array();
		if ( $match === 'category' ) {
			SinglePost::getInstance()->recursive_category( get_the_category(), $result );

			if ( $result ) {
				foreach ( $result as $cat ) {
					$category[] = $cat->term_id;
				}
			}
		} elseif ( $match === 'tag' ) {
			$tags = get_the_tags();
			if ( $tags ) {
				foreach ( $tags as $cat ) {
					$tag[] = $cat->term_id;
				}
			}
		}

		$attribute = array(
			'first_title'             => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_ftitle', 'Related' ) : jnews_return_translation( 'Related', 'jnews', 'related' ),
			'second_title'            => get_theme_mod( 'jnews_single_post_related_override_title', false ) ? get_theme_mod( 'jnews_single_post_related_stitle', 'Posts' ) : jnews_return_translation( ' Posts', 'jnews', 'posts' ),
			'header_type'             => $attr['header_type'],
			'date_format'             => $attr['date'],
			'date_format_custom'      => $attr['date_custom'],
			'excerpt_length'          => $attr['excerpt'],
			'pagination_number_post'  => $attr['number'],
			'number_post'             => $attr['number'],
			'include_category'        => implode( ',', $category ),
			'include_tag'             => implode( ',', $tag ),
			'exclude_post'            => get_the_ID(),
			'sort_by'                 => $attr['sort_by'],
			'pagination_mode'         => $attr['pagination'],
			'pagination_scroll_limit' => $attr['auto_load'],
			'paged'                   => 1,
			'column_width'            => $attr['column_width'], // see TtGCsH5v
		);

		$name = 'JNews_Block_' . str_replace( 'template_', '', $attr['template'] );
		$name = jnews_get_view_class_from_shortcode( $name );

		/** @var $content_instance BlockViewAbstract */
		$content_instance = jnews_get_module_instance( $name );
		$result           = $content_instance->build_module( $attribute );

		return "<div {$this->element_id($attr)} class='jnews_related_post_container jeg_custom_related_wrapper {$attr['scheme']} {$attr['el_class']} {$this->get_vc_class_name()}'>" .
				$result .
			'</div>';
	}
}
