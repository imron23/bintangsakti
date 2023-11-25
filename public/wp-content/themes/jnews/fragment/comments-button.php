<?php
global $post;
?>

<div id="comments" class="ajax_comment_button" data-post-type="<?php esc_html_e($post->post_type); ?>" data-id="<?php esc_html_e($post->ID); ?>" data-loading="<?php jnews_print_translation('Loading Comment', 'jnews', 'loading-comment'); ?>">
    <span class="button">
        <?php
            if(jnews_get_comments_number($post->ID)) {
                jnews_print_translation('Read All Comment', 'jnews', 'read-comment');
            } else {
                jnews_print_translation('Leave Comment', 'jnews', 'leave-comment');
            }
        ?>
    </span>
</div>