<?php
/**
 * Main admin class
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 1.1.0
 */

if ( !defined( 'YITH_WOO_FEATURED_VIDEO' ) ) { exit; } // Exit if accessed directly

$options = array(
    'general' => array(
        array(
            'name' => __( 'General Settings', 'yit' ),
            'type' => 'title',
            'desc' => '',
            'id' => 'yith_woo_featured_video_general'
        ),

        /*array(
            'name' => __( 'Link/Button text', 'yit' ),
            'desc' => __( 'Type the text to use for the button or the link of the compare.', 'yit' ),
            'id'   => 'yith_woo_featured_video_button_text',
            'std'  => __( 'Compare', 'yit' ),
            'type' => 'text'
        ),*/

        array( 'type' => 'sectionend', 'id' => 'yith_woo_featured_video_general' )
    ),
);
