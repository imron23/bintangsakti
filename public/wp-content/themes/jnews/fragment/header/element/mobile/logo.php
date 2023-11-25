<div class="jeg_nav_item jeg_mobile_logo">
	<?php if ( is_front_page() ) : ?>
	    <div class="site-title">
	    	<a href="<?php echo esc_url(jnews_home_url_multilang('/')); ?>">
		        <?php jnews_generate_mobile_logo(); ?>
		    </a>
	    </div>
	<?php else : ?>
		<div class="site-title">
	    	<a href="<?php echo esc_url(jnews_home_url_multilang('/')); ?>">
		        <?php jnews_generate_mobile_logo(); ?>
		    </a>
	    </div>
	<?php endif; ?>
</div>