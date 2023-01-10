<?php
/**
 * Plugin Name: YITH Woocommerce Featured Video
 * Plugin URI: http://yithemes.com/
 * Description: YITH Woocommerce Featured video allows you to set a video instead of featured image on the single product page.
 * Version: 1.1.1
 * Author: Your Inspiration Themes
 * Author URI: http://yithemes.com/
 * Text Domain: yit
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Featured Video
 * @version 1.1.0
 */
/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/* Include common functions */
if( !defined('YITH_FUNCTIONS') ) {
    require_once( 'yit-common/yit-functions.php' );
}

function yith_woo_featured_video_constructor() {
    global $woocommerce;
    if ( ! isset( $woocommerce ) ) return;

    load_plugin_textdomain( 'yit', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

    define( 'YITH_WOO_FEATURED_VIDEO', true );
    define( 'YITH_WOO_FEATURED_VIDEO_VERSION', '1.1.1' );
    define( 'YITH_WOO_FEATURED_VIDEO_URL', plugin_dir_url( __FILE__ ) );
    define( 'YITH_WOO_FEATURED_VIDEO_DIR', plugin_dir_path( __FILE__ ) );

    // Load required classes and functions
    require_once( 'functions.yith-woo-featured-video.php' );
    require_once( 'class.yith-woo-featured-video-admin.php' );
    require_once( 'class.yith-woo-featured-video-frontend.php' );
    require_once( 'class.yith-woo-featured-video.php' );

    // Let's start the game!
    global $yith_woo_featured_video;
    $yith_woo_featured_video = new YITH_Woo_Featured_Video();
}
add_action( 'plugins_loaded', 'yith_woo_featured_video_constructor' );
