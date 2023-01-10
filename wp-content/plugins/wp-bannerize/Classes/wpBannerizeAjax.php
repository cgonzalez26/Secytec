<?php
/**
 * Ajax Engine
 *
 * @package         wpBannerize
 * @subpackage      wpBannerizeAjax
 * @author          =undo= <g.fazioli@undolog.com>, <g.fazioli@wpxtre.me>
 * @copyright       Copyright (C) 2008-2013
 *
 */

if ( @isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
  function wpBannerizeInlineEdit()
  {
    global $wpBannerizeAdmin;

    $postID = intval( $_POST['id'] );
    echo $wpBannerizeAdmin->inlineEdit( $postID );
    die();
  }

  add_action( 'wp_ajax_wpBannerizeInlineEdit', 'wpBannerizeInlineEdit' );


  function wpBannerizeClickCounter()
  {
    global $wpdb;
    $postID = intval( $_POST['id'] );
    $sql    = sprintf( 'UPDATE `%s` SET `clickcount` = `clickcount`+1 WHERE id = %s', ( $wpdb->prefix .
      kWPBannerizeTableName ), $postID );
    $result = $wpdb->query( $sql );
    die();
  }

  add_action( 'wp_ajax_wpBannerizeClickCounter', 'wpBannerizeClickCounter' );
  add_action( 'wp_ajax_nopriv_wpBannerizeClickCounter', 'wpBannerizeClickCounter' );


  function wpBannerizeSorter()
  {
    global $wpdb;
    $limit       = intval( $_POST['limit'] );
    $page_offset = ( intval( $_POST['offset'] ) - 1 ) * $limit;

    foreach ( $_POST["item"] as $key => $value ) {
      $sql    = sprintf( 'UPDATE `%s` SET `sorter` = %s WHERE id = %s',
        $wpdb->prefix . kWPBannerizeTableName, ( intval( $key ) + $page_offset ), intval( $value ) );
      $result = $wpdb->query( $sql );
    }
    die();
  }

  add_action( 'wp_ajax_wpBannerizeSorter', 'wpBannerizeSorter' );


  function wpBannerizeUpdate()
  {
    global $wpBannerizeAdmin;
    echo $wpBannerizeAdmin->updateBanner();
    die();
  }

  add_action( 'wp_ajax_wpBannerizeUpdate', 'wpBannerizeUpdate' );


  function wpBannerizeSetEnabled()
  {
    global $wpdb;
    $postID  = intval( $_POST['id'] );
    $enabled = intval( $_POST['enabled'] );
    $sql     = sprintf( 'UPDATE `%s` SET `enabled` = "%s" WHERE id = %s',
      $wpdb->prefix . kWPBannerizeTableName, $enabled, $postID );
    $result  = $wpdb->query( $sql );
    die();
  }

  add_action( 'wp_ajax_wpBannerizeSetEnabled', 'wpBannerizeSetEnabled' );


  function wpBannerizeRowItemWithID()
  {
    global $wpBannerizeAdmin;
    $postID = intval( $_POST['id'] );
    $wpBannerizeAdmin->rowItemWithID( $postID );
    die();
  }

  add_action( 'wp_ajax_wpBannerizeRowItemWithID', 'wpBannerizeRowItemWithID' );
}