<?php
/**
 * Main class for sub.classing backend and frontend class
 *
 * @class        WPBannerizeClass
 * @package      wpBannerize
 * @subpackage   wpBannerizeClass
 * @author       =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright    Copyright (C) 2008-2013
 *
 */

class WPBannerizeClass {

	/**
	 * Plugin version (see above)
	 *
	 * @since 2.4.7
	 * @var string
	 */
	var $version = kWPBannerizeVersion;

	/**
	 * WP Bannerize release.minor.revision
	 *
	 * @since 2.3.0
	 * @var integer
	 */
	var $release = '';
	var $minor = '';
	var $revision = '';
	var $minorRevision = '';

	/**
	 * Plugin name
	 *
	 * @since 1.0.0
	 * @var string
	 */
	var $plugin_name = kWPBannerizePluginName;

	/**
	 * Plugin slug
	 *
	 * @since 2.5.0
	 * @var string
	 */
	var $plugin_slug = kWPBannerizeSlugName;

	/**
	 * Key for database options
	 *
	 * @since 1.0.0
	 * @var string
	 */
	var $options_key = kWPBannerizeOptionsKey;

	/**
	 * Options array containing all options for this plugin
	 *
	 * @since 1.0.0
	 * @var array
	 */
	var $options = array ();

	/**
	 * Backend title
	 *
	 * @since 1.0.0
	 * @var string
	 */
	var $options_title = kWPBannerizeOptionTitle;

	/**
	 * Property for table name
	 *
	 * @since 1.4.0
	 * @var string
	 */
	var $table_bannerize;
	var $old_table_bannerize;

	var $content_url = '';
	var $plugin_url = '';

	/**
	 * Wordpress Ajax URL
	 *
	 * @since 3.0.0
	 * @var string
	 */
	var $ajaxURL = '';

	var $path = '';
	var $file = '';
	var $directory = '';
	var $uri = '';
	var $url = '';
	var $siteurl = '';
	var $wpadminurl = '';

	var $error = false;

	/**
	 * Standard PHP 4 constructor
	 *
	 * @since 3.0.50
	 * @global object $wpdb
	 * @global object $wpdb
	 */
	function WPBannerizeClass( $__file__ ) {
		global $wpdb;

		/**
		 * Split version for more detail
		 */
		$splitVersion   = explode( ".", $this->version );
		$this->release  = $splitVersion[0];
		$this->minor    = $splitVersion[1];
		$this->revision = isset( $splitVersion[2] ) ? $splitVersion[2] : '';
		if ( count( $splitVersion ) > 3 ) {
			$this->minorRevision = $splitVersion[3]; // @since 2.7.1.1
		}

		// Build the common and usefull path
		$this->url = plugins_url( "", $__file__ );

		if ( !defined( 'WP_CONTENT_DIR' ) ) {
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		}

		if ( !defined( 'WP_CONTENT_URL' ) ) {
			define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
		}

		if ( !defined( 'WP_ADMIN_URL' ) ) {
			define( 'WP_ADMIN_URL', get_option( 'siteurl' ) . '/wp-admin' );
		}

		if ( !defined( 'WP_PLUGIN_DIR' ) ) {
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
		}

		if ( !defined( 'WP_PLUGIN_URL' ) ) {
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );
		}

		/**
		 * Add $wpdb->prefix to table name define in kWPBannerizeTableName. This featured makes wp-bannerize compatible
		 * with Wordpress MU and Wordpress with different database prefix
		 *
		 * @since 2.2.1
		 */
		$this->table_bannerize = $wpdb->prefix . kWPBannerizeTableName;

		/**
		 * Used for check previous 3.0 release database table name
		 *
		 * @since 2.5.0
		 */
		$this->prev_table_bannerize = $wpdb->prefix . kWPBannerizeTableName_3_0;

		$this->path       = dirname( $__file__ );
		$this->file       = basename( $__file__ );
		$this->directory  = basename( $this->path );
		$this->uri        = plugins_url( '', $__file__ );
		$this->siteurl    = get_bloginfo( 'url' );
		$this->wpadminurl = admin_url();

		$this->content_url = get_option( 'siteurl' ) . '/wp-content';
		$this->plugin_url  = $this->content_url . '/plugins/' . plugin_basename( dirname( $__file__ ) ) . '/';

		// New Engine Ajax
		$protocol      = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
		$this->ajaxURL = admin_url( 'admin-ajax.php', $protocol );

	}
}

/**
 * Widget support
 *
 * @since 2.3.5
 */
if ( class_exists( "WP_Widget" ) ) {
	require_once( 'wpBannerizeWidget.php' );
	add_action( 'widgets_init', create_function( '',
		'return register_widget("' . kWPBannerizeWidgetClassName . '");' ) );
}