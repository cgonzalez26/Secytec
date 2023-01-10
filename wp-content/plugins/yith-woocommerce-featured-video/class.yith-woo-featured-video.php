<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Featured Video
 * @version 1.1.0
 */

if ( !defined( 'YITH_WOO_FEATURED_VIDEO' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_Woo_Featured_Video' ) ) {
    /**
     * YITH Woocommerce Featured Video
     *
     * @since 1.0.0
     */
    class YITH_Woo_Featured_Video {

        /**
         * Plugin object
         *
         * @var string
         * @since 1.0.0
         */
        public $obj = null;

        /**
         * AJAX Helper
         *
         * @var string
         * @since 1.0.0
         */
        public $ajax = null;

        /**
         * Constructor
         *
         * @return mixed|YITH_Woo_Featured_Video|YITH_Woo_Featured_video_Frontend
         * @since 1.0.0
         */
        public function __construct() {
            if( $this->is_frontend() ) {
                $this->obj = new YITH_Woo_Featured_Video_Frontend();
            } elseif( $this->is_admin() ) {
                $this->obj = new YITH_Woo_Featured_Video_Admin();
            }

            return $this->obj;
        }

        /**
         * Detect if is frontend
         * @return bool
         */
        public function is_frontend() {
            $is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
            return (bool) ( ! is_admin() || $is_ajax && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend' );
        }

        /**
         * Detect if is admin
         * @return bool
         */
        public function is_admin() {
            $is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
            return (bool) ( is_admin() || $is_ajax && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'admin' );
        }
    }
}