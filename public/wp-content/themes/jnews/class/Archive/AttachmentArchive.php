<?php
/**
 * @author : Jegtheme
 */

namespace JNews\Archive;

/**
 * Class AttachmentArchive
 * @package JNews\Archive
 */
Class AttachmentArchive extends ArchiveAbstract {
	public function get_content_width() {
		$width = parent::get_content_width();

		if ( in_array( $this->get_page_layout(), [ 'right-sidebar', 'left-sidebar' ] ) ) {
			$sidebar = $this->get_content_sidebar();
			if ( ! is_active_sidebar( $sidebar ) ) {
				return 12;
			}
		}

		return $width;
	}

	public function get_page_layout() {
		return apply_filters( 'jnews_attachment_page_layout', get_theme_mod( 'jnews_attachment_page_layout', 'right-sidebar' ) );
	}

	public function get_content_sidebar() {
		return apply_filters( 'jnews_attachment_sidebar', get_theme_mod( 'jnews_attachment_sidebar', 'default-sidebar' ) );
	}

	public function get_second_sidebar() {
		return apply_filters( 'jnews_attachment_second_sidebar', get_theme_mod( 'jnews_attachment_second_sidebar', 'default-sidebar' ) );
	}

	public function sticky_sidebar() {
		return apply_filters( 'jnews_attachment_sticky_sidebar', get_theme_mod( 'jnews_attachment_sticky_sidebar', true ) );
	}

	public function get_content_type() {
	}

	public function get_content_excerpt() {
	}

	public function get_content_date() {
	}

	public function get_content_date_custom() {
	}

	public function get_content_pagination() {
	}

	public function get_content_pagination_limit() {
	}

	public function get_content_pagination_align() {
	}

	public function get_content_pagination_navtext() {
	}

	public function get_content_pagination_pageinfo() {
	}

	public function get_boxed() {
	}

	public function get_boxed_shadow() {
	}

	public function get_box_shadow() {
	}
}
