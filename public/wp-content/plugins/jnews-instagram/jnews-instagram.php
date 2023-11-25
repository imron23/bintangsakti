<?php
/*
	Plugin Name: JNews - Instagram Feed
	Plugin URI: http://jegtheme.com/
	Description: Put your instagram feed on the header and footer of your website
	Version: 11.0.1
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/


defined( 'JNEWS_INSTAGRAM' ) or define( 'JNEWS_INSTAGRAM', 'jnews-instagram' );
defined( 'JNEWS_INSTAGRAM_VERSION' ) || define( 'JNEWS_INSTAGRAM_VERSION', '11.0.1' );
defined( 'JNEWS_INSTAGRAM_URL' ) or define( 'JNEWS_INSTAGRAM_URL', plugins_url( JNEWS_INSTAGRAM ) );
defined( 'JNEWS_INSTAGRAM_FILE' ) or define( 'JNEWS_INSTAGRAM_FILE', __FILE__ );
defined( 'JNEWS_INSTAGRAM_DIR' ) or define( 'JNEWS_INSTAGRAM_DIR', plugin_dir_path( __FILE__ ) );
defined( 'JNEWS_INSTAGRAM_FEED_CACHE' ) or define( 'JNEWS_INSTAGRAM_FEED_CACHE', 'jnews_instagram_feed_cache' );

require_once 'autoload.php';

JNEWS_INSTAGRAM\Init::get_instance();
