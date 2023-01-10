<?php
/**
 * Wrap for allow to call a simple function from Wordpress envirorment
 *
 * @package         wpBannerize
 * @subpackage      wpBannerizeFunctions
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright       Copyright (C) 2008-2013
 *
 */

/**
 * Comodity function for Show banner list
 *
 * @return void
 *
 * @param array|object $args [optional]
 *
 * @see WPBannerizeFrontend Class
 */
function wp_bannerize( $args = array() )
{
  global $wpBannerizeFrontend;
  echo $wpBannerizeFrontend->bannerize( $args );
}