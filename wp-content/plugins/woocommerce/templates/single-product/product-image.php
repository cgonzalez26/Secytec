<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>
<script defer="" src="wp-content/plugins/flexslider-master/jquery.flexslider.js"></script>
<script src="wp-includes/js/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="wp-content/plugins/flexslider-master/flexslider.css" type="text/css" media="screen">
<script src="wp-content/plugins/flexslider-master/demo/js/modernizr.js"></script> 

<script>
$(window).load(function() {
	  $('#article-slider').flexslider({
	    animation: "slide",
	    animationLoop: false,
	    controlNav: false,
	    slideshow: false,
	    itemWidth: 700,
	    itemMargin: 15        
	  });
	});
</script>
<style>
.flex-viewport{
	margin:0px;
	padding:0px;
}
.carousel img{
	opacity:1;
}
.carousel img:hover{
	opacity:1; 
}

.flex-next{
	right:0px;
}
</style>
<div class="images">

	<?php
		/*if ( has_post_thumbnail() ) {

			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			/*$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', '' ), array(
				'title' => $image_title
				) );

			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

		}cristian*/
	?>
	<section class="slider" style="width:100%;padding:0px;margin:0px">
		<div id="article-slider" class="flexslider carousel" style="width:100%;padding:0px;margin:0px">
		  <ul class="slides" style="width:100%;padding:0px;margin:0px">		   
		    <?php
		    
		    	global $wpdb;
		    	if ( has_post_thumbnail() ) {
			    	//$q    = "SELECT * FROM wp_bannerize WHERE wp_bannerize.group='inicio' ";
					//$rows = $wpdb->get_results( $q ); 
					$image_link= wp_get_attachment_url( get_post_thumbnail_id() );
					$attachment_ids = $product->get_gallery_attachment_ids();
					echo "<li style='margin:0px'>
				      		<img src='".$image_link."' style='height:auto; max-width:100%;' /><!-- daniel 16/01/15 -->
				    </li>";
						
					if ( $attachment_ids ) {
						foreach ( $attachment_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id );
							echo "<li style='margin:0px'>
						      		<img src='".$image_link."' style='height:auto; max-width:100%;' /><!-- daniel 16/01/15 -->
						    </li>";
						}
					}
		    	}
		    ?>
		  </ul>
		</div>
      </section>	 
	<div class="share-buttons-line">
			<?php smartadapt_get_social_buttons(); ?>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	
</div>
