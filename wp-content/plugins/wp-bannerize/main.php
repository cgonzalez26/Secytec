<?php
/**
 * Plugin Name: WP Bannerize
 * Plugin URI: http://wordpress.org/extend/plugins/wp-bannerize/
 * Description: WP Bannerize: an easy to use adv server with html, free text and Flash banner support.
 * Version: 3.1.6
 * Author: gfazioli
 * Author URI: http://www.undolog.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

require_once( trailingslashit( dirname( __FILE__ ) ) . 'main.h.php' );
require_once( trailingslashit( dirname( __FILE__ ) ) . 'Classes/wpBannerizeClass.php' );

if ( @isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
  require_once( trailingslashit( dirname( __FILE__) ) . 'Classes/wpBannerizeAdmin.php' );
  $wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
  require_once( trailingslashit( dirname( __FILE__) ) . 'Classes/wpBannerizeAjax.php' );
}
else {
  if ( is_admin() ) {
    require_once( trailingslashit( dirname( __FILE__ ) ) . 'Classes/wpBannerizeAdmin.php' );
    //
    $wpBannerizeAdmin = new WPBannerizeAdmin( __FILE__ );
    $wpBannerizeAdmin->register_plugin_settings( __FILE__ );
    register_activation_hook( __FILE__, array( &$wpBannerizeAdmin, 'pluginDidActive' ) );
    register_activation_hook( __FILE__, array( &$wpBannerizeAdmin, 'pluginDidDeactive' ) );
  }
  else {
    require_once( trailingslashit( dirname( __FILE__ ) ) . 'Classes/wpBannerizeFrontend.php' );
    $wpBannerizeFrontend = new WPBannerizeFrontend( __FILE__ );
    require_once( trailingslashit( dirname( __FILE__ ) ) . 'Classes/wpBannerizeFunctions.php' );
  }
}