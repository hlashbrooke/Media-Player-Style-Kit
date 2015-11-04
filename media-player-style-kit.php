<?php
/*
 * Plugin Name: Media Player Style Kit
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: Change the colors of the WordPress media player right from the Customizer.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.3
 * Tested up to: 4.4
 *
 * Text Domain: media-player-style-kit
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-media-player-style-kit.php' );

/**
 * Returns the main instance of Media_Player_Style_Kit to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Media_Player_Style_Kit
 */
function Media_Player_Style_Kit () {
	$instance = Media_Player_Style_Kit::instance( __FILE__, '1.0.0' );
	return $instance;
}

Media_Player_Style_Kit();
