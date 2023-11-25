<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<label>
	<?php if ( VP_Metabox::_is_post_or_page() ) : ?>
		<input type="hidden" name="<?php echo esc_attr($name); ?>" value="0"/>
	<?php endif; ?>
	<input <?php if( $value ) echo 'checked'; ?> class="vp-input<?php if( $value ) echo ' checked'; ?>" type="checkbox" name="<?php echo esc_attr($name); ?>" value="1" />
	<span></span>
</label>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>