<?php
/**
 * Global defines and constant
 *
 * @package         wpBannerize
 * @subpackage      wpBannerizeDefines
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright       Copyright (C) 2008-2013
 *
 */

// Internal use
define( 'kWPBannerizeDebug', false );

// Common
define( 'kWPBannerizeVersion', '3.1.6' );
define( 'kWPBannerizePluginName', 'WP Bannerize' );
define( 'kWPBannerizeOptionTitle', kWPBannerizePluginName );
define( 'kWPBannerizeSlugName', 'wp-bannerize' );
define( 'kWPBannerizeShortcodeName', 'wp_bannerize' );
define( 'kWPBannerizeUserCapabilitiy', 'edit_posts' );
define( 'kWPBannerizeMaxFileSize', 10000000 );

// Widget Class
define( 'kWPBannerizeWidgetClassName', 'WPBannerizeWidget' );

// Type of banner
define( 'kWPBannerizeBannerTypeFromLocal', 1 );
define( 'kWPBannerizeBannerTypeByURL', 2 );
define( 'kWPBannerizeBannerTypeFreeHTML', 3 );

// Javascript include
define( 'kWPBannerizeJavascriptAdmin', '/js/wpBannerizeAdmin.min.js' );
define( 'kWPBannerizeJavascriptFrontend', '/js/wpBannerizeFrontend.min.js' );

// Backend css rules
define( 'kWPBannerizeBannerStyleAdmin', '/css/wpBannerizeAdmin.min.css' );

// Frontend css rules
define( 'kWPBannerizeBannerStyleDefault', 'wpBannerizeStyleDefault.css' );
define( 'kWPBannerizeBannerStyleInline', 'wpBannerizeStyleInline.css' );

// MetaBox key
define( 'kWPBannerizeMetaBoxSettingsKey', 'wpBannerizeMetaBoxSettings' );
define( 'kWPBannerizeMetaBoxToolsKey', 'wpBannerizeMetaBoxTools' );
define( 'kWPBannerizeMetaBoxToolsDatabaseKey', 'wpBannerizeMetaBoxToolsDatabase' );

// Database
define( 'kWPBannerizeTableName_3_0', 'bannerize_b' ); ///< Name of Database table before 3.0
define( 'kWPBannerizeTableName', 'bannerize' ); ///< Name of Database table from 3.0
define( 'kWPBannerizeOptionsKey', 'wp-bannerize' ); ///< Option Key @since 2.7.0.3

// Form sender and receive an
define( 'kWPBannerizeFormSender', 'wpBannerizeFormSender' );
define( 'kWPBannerizeFormAction', 'wpBannerizeFormAction' );

// Form action/command
define( 'kWPBannerizeFormActionTruncateTable', 'wpBannerizeFormActionTruncateTable' );