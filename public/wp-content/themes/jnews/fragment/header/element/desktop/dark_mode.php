<?php
/**
 * ----- DARK MODE TOGGLE ----- *
 * */
$dm_options = get_theme_mod('jnews_dark_mode_options', 'jeg_toggle_light');

if ( $dm_options === 'jeg_toggle_light' || $dm_options === 'jeg_toggle_dark' || $dm_options === 'jeg_device_toggle' ) {
	$checked = isset( $_COOKIE['darkmode'] ) && $_COOKIE['darkmode'] === 'true' ? 'checked' : '';
    $div_dark = "<div class=\"jeg_nav_item jeg_dark_mode\">
                    <label class=\"dark_mode_switch\">
                        <input type=\"checkbox\" class=\"jeg_dark_mode_toggle\" $checked>
                        <span class=\"slider round\"></span>
                    </label>
                 </div>";

    echo jnews_sanitize_by_pass( $div_dark );
}