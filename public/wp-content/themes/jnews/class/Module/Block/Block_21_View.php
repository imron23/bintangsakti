<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Block;

Class Block_21_View extends BlockViewAbstract
{
    public function render_block_type_1($post, $image_size)
    {
        $post_id            = $post->ID;
        $additional_class   = (!has_post_thumbnail($post_id)) ? ' no_thumbnail' : '';
        $permalink          = get_the_permalink($post);
        
        return  "<article " . jnews_post_class("jeg_post jeg_pl_sm" . $additional_class, $post_id) . ">
                    <div class=\"jeg_thumb\">
                        " . jnews_edit_post($post_id) . "
                        <a href=\"{$permalink}\">{$this->get_thumbnail($post_id, $image_size)}</a>
                    </div>
                    <div class=\"jeg_postblock_content\">
                        <h3 class=\"jeg_post_title\">
                            <a href=\"{$permalink}\">" . get_the_title($post) . "</a>
                        </h3>
                        {$this->post_meta_2($post)}
                    </div>
                </article>";
    }

    public function build_column($results)
    {
        $first_block = '';
        $size = sizeof($results);
        for($i = 0; $i < $size; $i++) {
            $first_block .= $this->render_block_type_1($results[$i], 'jnews-120x86');
        }

        return $first_block;
    }

    public function render_output($attr, $column_class)
    {
        $results =  isset( $attr['results']) ? $attr['results'] : $this->build_query( $attr );
		$navigation = $this->render_navigation( $attr, $results['next'], $results['prev'], $results['total_page'] );
        $content = ! empty( $results['result'] ) ? $this->render_column( $results['result'], $column_class ) :  $this->empty_content();

        return  "<div class=\"jeg_block_container\">
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

    public function render_column($result, $column_class)
    {
        return "<div class=\"jeg_posts jeg_load_more_flag\">{$this->build_column($result)}</div>";
    }

    public function render_column_alt($result, $column_class)
    {
        return $this->build_column($result);
    }
}
