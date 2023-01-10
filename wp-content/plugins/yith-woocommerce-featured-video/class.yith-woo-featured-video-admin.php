<?php
/**
 * Admin class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Magnifier
 * @version 1.1.0
 */

if ( !defined( 'YITH_WOO_FEATURED_VIDEO' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_Woo_Featured_Video_Admin' ) ) {
    /**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
class YITH_Woo_Featured_Video_Admin {
    /**
     * Plugin version
     *
     * @var string
     * @since 1.0.0
     */
    public $version = YITH_WOO_FEATURED_VIDEO_VERSION;

    /**
     * Plugin options
     *
     * @var array
     * @access public
     * @since 1.0.0
     */
    public $options = array();

    /**
     * Plugin options
     *
     * @var array
     * @access public
     * @since 1.0.0
     */
    public $services = array(
        'youtube' => 'Youtube',
        'vimeo' => 'Vimeo',
        /*'dailymotion' => 'Daily Motion',
        'yahoo' => 'Yahoo',
        'bliptv' => 'Blip TV',
        'veoh' => 'Veoh',
        'viddler' => 'Viddler'*/
    );


    /**
     * Constructor
     *
     * @access public
     * @since 1.0.0
     */
    public function __construct() {

        // Admin fields
        add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_video_field' ) );
        add_action( 'woocommerce_process_product_meta', array( $this, 'save_video_url' ), 10, 2 );

        // YITH WCWL Loaded
        do_action( 'yith_woo_featured_video_loaded' );
    }

    /**
     * Add the field in the product data box
     */
    public function add_video_field() {

        echo '<div class="options_group">';

        // Expirey
        woocommerce_wp_text_input( array(
            'id' => '_video_url',
            'label' => __( 'Featured Video URL', 'yit' ),
            'placeholder' => __( 'Video URL', 'yit' ),
            'desc_tip' => true,
            'description' => sprintf( __( 'Enter the URL for the video you want to show in place of the featured image in the product detail page. (the services enabled are: %s).', 'yit' ), implode( ', ', $this->services ) )
        ) );

        echo '</div>';

    }

    public function save_video_url( $post_id, $post ) {
        if ( isset( $_POST['_video_url'] ) )
            update_post_meta( $post_id, '_video_url', esc_url( $_POST['_video_url'] ) );
    }

}
}
