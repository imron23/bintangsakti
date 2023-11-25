<?php
global $post;

$commenttype = apply_filters( 'jeg_comment_type', get_theme_mod( 'jnews_comment_type', 'wordpress' ) );

if ( $commenttype === 'facebook' ) {
	echo '<div id="comments" class="comment-wrapper section" data-type="' . esc_attr( $commenttype ) . '" data-id="' . esc_attr( apply_filters( 'jeg_comment_id', get_theme_mod( 'jnews_comment_facebook_appid', '' ) ) ) . '">';
	echo "<h3 class='comment-heading'>";
	printf( jnews_return_translation( 'Discussion about this %s', 'jnews', 'discussion_about_this' ), $post->post_type );
	echo "</h3>";
	echo '<div class="fb-comments" data-href="' . get_the_permalink() . '" data-num-posts="10" data-width="100%"></div>';
	echo '</div>';
} else if ( $commenttype === 'disqus' ) {
	echo '<div id="comments" class="comment-wrapper section" data-type="' . esc_attr( $commenttype ) . '" data-id="' . esc_attr( apply_filters( 'jeg_comment_id', get_theme_mod( 'jnews_comment_disqus_shortname', '' ) ) ) . '">';
	echo "<h3 class='comment-heading'>";
	printf( jnews_return_translation( 'Discussion about this %s', 'jnews', 'discussion_about_this' ), $post->post_type );
	echo "</h3>";
	echo '<div class="comment_disqus">';
    echo '<div id="disqus_thread"></div>';
    echo '</div>';
    echo '</div>';
} else {

	if ( comments_open() || get_comments_number() ) {
		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
			echo '<div id="comments" class="comment-wrapper section">';

			if ( get_theme_mod( 'jnews_comment_login', false ) ) {
				add_filter( 'jnews_can_render_account_popup', '__return_true' );

				echo "<span class='comment-login'>" .
				     sprintf(
					     jnews_return_translation( "Please <a href='%s' class='%s'>login</a> to join discussion", "jnews", 'please_login_join_discussion', false ),
					     '#jeg_loginform',
					     'jeg_popuplink'
				     )
				     . "</span>";
			} else {
				echo "<span class='comment-login'>" .
				     sprintf(
					     jnews_return_translation( "Please <a href='%s' class='%s'>login</a> to join discussion", "jnews", 'please_login_join_discussion', false ),
					     wp_login_url( esc_url( jnews_home_url_multilang( '/' ) ), false ),
					     ''
				     )
				     . "</span>";
			}

			echo '</div>';
		} else {
			if ( have_comments() ) { ?>
                <div id="comments" class="jeg_comments">
                    <h3 class="comments-title">
						<?php jnews_print_translation( 'Comments', 'jnews', 'comments' ); ?>
                        <span class="count"><?php echo esc_html( number_format_i18n( jnews_get_comments_number() ) ); ?></span>
                    </h3>

                    <div class="jeg_commentlist_container">
                        <ol class="commentlist">
							<?php
							wp_list_comments( array(
								'avatar_size' => '55',
								'short_ping'  => true,
								'walker'      => new \JNews\Comment\CommentWalker
							) );
							?>
                        </ol>
                    </div>

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                        <div class="comment-navigation navigation">
                            <div class="prev-comment">
								<?php next_comments_link( jnews_return_translation( 'Previous', 'jnews', 'previous' ) ) ?>
                            </div>
                            <div class="next-comment">
								<?php previous_comments_link( jnews_return_translation( 'Next', 'jnews', 'next' ) ) ?>
                            </div>
                        </div>
					<?php endif; ?>
                </div>

				<?php
			}

			comment_form();
		}
	}
}
