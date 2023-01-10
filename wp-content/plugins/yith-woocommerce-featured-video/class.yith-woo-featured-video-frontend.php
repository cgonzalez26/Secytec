<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Featured Video
 * @version 1.1.0
 */

if ( !defined( 'YITH_WOO_FEATURED_VIDEO' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_Woo_Featured_Video_Frontend' ) ) {
    /**
     * YITH Custom Login Frontend
     *
     * @since 1.0.0
     */
    class YITH_Woo_Featured_Video_Frontend {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WOO_FEATURED_VIDEO_VERSION;

        /**
         * The URL of the video in current product detail page
         *
         * @var bool|string
         * @since 1.0.0
         */
        public $video_url = false;

        /**
         * Constructor
         *
         * @return YITH_Woo_Featured_video_Frontend
         * @since 1.0.0
         */
        public function __construct() {
            add_filter( 'woocommerce_single_product_image_html', array( $this, 'set_featured_video' ), 20 );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'wp_head', array( $this, 'set_video_url' ), 0 );

            return $this;
        }

        /**
         * Enqueue the scripts and styles in the page
         */
        public function enqueue_scripts() {
            wp_enqueue_style(  'yith-woo-featured-video', YITH_WOO_FEATURED_VIDEO_URL . 'assets/css/woo-featured-video.css' );
            wp_enqueue_script( 'yith-woo-featured-video', YITH_WOO_FEATURED_VIDEO_URL . 'assets/js/woo-featured-video.js', array('jquery'), $this->version, true );
        }

        /**
         * Get the video URL for the current page
         */
        public function set_video_url() {
            global $post;
            $post_id = isset( $post->ID ) ? $post->ID : 0;

            $video_url = get_post_meta( $post_id, '_video_url', true );
            $this->video_url = empty( $video_url ) ? false : $video_url;
        }

        /**
         * Set a video player instead of featured image in the single product
         *
         * @param $html
         * @return mixed
         */
        public function set_featured_video( $html ) {
            global $post, $woocommerce;

            if ( ! $this->video_url ) return $html;

            // size
            if ( function_exists( 'wc_get_image_size' ) ) {
                $size	= wc_get_image_size( apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
            } else {
                $size	= $woocommerce->get_image_size( apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
            }
            $width  = $size['width'];
            $height = $size['height'];

            list( $video_type, $video_id ) = explode( ':', $this->video_type_by_url( $this->video_url ) );

            ob_start();

            if ( $video_type == 'youtube' ) {
                $video_id = preg_replace( '/[&|&amp;]feature=([\w\-]*)/', '', $video_id );
                wp_enqueue_script( 'youtube-api', 'http://www.youtube.com/player_api' ); ?>
                <div class="product-video youtube">
                    <iframe wmode="transparent" id="player-<?php echo $video_id; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="http://www.youtube.com/embed/<?php echo $video_id; ?>?wmode=transparent" onload="floaded()" frameborder="0" allowfullscreen=""></iframe>
                </div>

                <script>
                    //onYouTubePlayerAPIReady
                    var player;
                    function floaded(){
                        player = new YT.Player('player-<?php echo $video_id; ?>', {
                            videoId: '<?php echo $video_id; ?>',
                            events:
                            {
                                'onStateChange': function (event)
                                {
                                    if (event.data == YT.PlayerState.PLAYING) {
                                        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').hide();

                                    } else if (event.data == YT.PlayerState.PAUSED) {
                                        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();

                                    } else {
                                        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();
                                    }
                                }
                            }

                        });
                    }

                </script>

                <?php
            } elseif ( $video_type == 'vimeo' ) { ?>
                <div class="product-video vimeo">
                    <iframe wmode="transparent" id="player-<?php echo $video_id; ?>" src="http://player.vimeo.com/video/<?php echo $video_id; ?>?title=0&amp;byline=0&amp;portrait=0&api=1&player_id=player-<?php echo $video_id; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>

                <script src="http://a.vimeocdn.com/js/froogaloop2.min.js" type="text/javascript"></script>
                <script>
                    var iframe = jQuery('#player-<?php echo $video_id; ?>')[0],
                        player = $f(iframe);

                    // When the player is ready, add listeners for pause, finish, and playProgress
                    player.addEvent('ready', function() {
                        player.addEvent('pause', show_onsale);
                        player.addEvent('finish', show_onsale);
                        player.addEvent('playProgress', hide_onsale);
                    });

                    function show_onsale(id) {
                        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').show();
                    }

                    function hide_onsale(data, id) {
                        jQuery('.woocommerce span.onsale:first, .woocommerce-page span.onsale:first').hide();
                    }
                </script>

                <?php

            } else {

                do_action( 'yith_woocommerce_featured_video_' . $video_type, $this->video_url );

            }

            $html = ob_get_clean();

            return $html;
        }

        /**
         * Retrieve the type of video, by url
         *
         * @param string $url The video's url
         * @return mixed A string format like this: "type:ID". Return FALSE, if the url isn't a valid video url.
         *
         * @since 1.0
         */
        public function video_type_by_url( $url ) {
            $parsed = parse_url( esc_url( $url ) );

            switch ( $parsed['host'] ) :

                case 'www.youtube.com' :
                    $id = $this->get_yt_video_id( $url );
                    return "youtube:$id";

                case 'vimeo.com' :
                    preg_match( '/http:\/\/(\w+.)?vimeo\.com\/(.*)/', $url, $matches );
                    $id = $matches[2];
                    return "vimeo:$id";

                default :
                    return apply_filters( 'yith_woocommerce_featured_video_type', false, $url );

            endswitch;
        }

        /**
         * Retrieve the id video from youtube url
         *
         * @param string $url The video's url
         * @return string The youtube id video
         *
         * @since 1.0
         */
        public function get_yt_video_id( $url ) {
            if ( preg_match( '/http:\/\/youtu.be/', $url, $matches) ) {
                $url = parse_url($url, PHP_URL_PATH);
                $url = str_replace( '/', '', $url);
                return $url;

            } elseif ( preg_match( '/watch/', $url, $matches) ) {
                $arr = parse_url($url);
                $url = str_replace( 'v=', '', $arr['query'] );
                return $url;

            } elseif ( preg_match( '/http:\/\/www.youtube.com\/v/', $url, $matches) ) {
                $arr = parse_url($url);
                $url = str_replace( '/v/', '', $arr['path'] );
                return $url;

            } elseif ( preg_match( '/http:\/\/www.youtube.com\/embed/', $url, $matches) ) {
                $arr = parse_url($url);
                $url = str_replace( '/embed/', '', $arr['path'] );
                return $url;

            } elseif ( preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+#", $url, $matches) ) {
                return $matches[0];

            } else {
                return false;
            }
        }

    }
}