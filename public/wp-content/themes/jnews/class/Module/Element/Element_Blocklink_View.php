<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleViewAbstract;
use JNews\Util\VideoAttribute;

Class Element_Blocklink_View extends ModuleViewAbstract
{
    public function load_youtube_api() {
        // use VC youtube API if loaded
        if ( ! wp_script_is( 'vc_youtube_iframe_api_js', 'enqueued' ) ) {
            wp_enqueue_script( 'jeg_youtube_api_js', '//www.youtube.com/iframe_api');
        }
    }

    public function render_module($attr, $column_class)
    {
        $newtab = ($attr['newtab']) ? "target=\"_blank\"" : "" ;
		$video = '';

        if ( isset( $attr['image']['url'] ) && ! empty( $attr['image']['url'] ) )
        {
	        $image_bg   = $attr['image']['url'];
        } else {
	        $image_bg   = wp_get_attachment_image_src($attr['image'], "jnews-1140x570");
	        $image_bg   = is_array($image_bg) ? $image_bg[0] : '';
        }

		if ( $attr['use_video_bg'] ) {
			$video_type = VideoAttribute::getInstance()->get_video_provider( $attr['video_url'] );
			$video_id   = VideoAttribute::getInstance()->get_video_id( $attr['video_url'] );

			if ($video_type == 'youtube' ) {
				$video ="<div class=\"jeg_videowrapper\"><div class=\"jeg_videobg\" data-youtubeid=\"{$video_id}\"></div></div>";
				$this->load_youtube_api();
			}
		}

        $output =
            "<div {$this->element_id($attr)} class=\"jeg_blocklink {$column_class} {$this->unique_id} {$this->get_vc_class_name()} {$attr['el_class']}\">
                <a href=\"{$attr['title_url']}\" {$newtab}>
                    <div class=\"jeg_block_container\">
                        <div class=\"jeg_block_bg\">
                            <div class=\"bg\" style=\"background-image:url('{$image_bg}')\"></div>
                            {$video}
                        </div>
                        <div class=\"jeg_block_content\">
                            <div>
                                <h3>{$attr['title']}</h3>
                                <span>{$attr['second_title']}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>";


        return $output;
    }

    public function render_column_alt($result, $column_class) {}
    public function render_column($result, $column_class) {}
}