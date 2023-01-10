<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $products, $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<!--  <li <?php //post_class( $classes ); ?>>
	<?php //do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php //the_permalink(); ?>">
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_shop_loop_item_title' );
			//echo get_the_post_thumbnail(the_ID(), 'shop_catalog');
		?>
		<h3><?php //the_title(); ?></h3>
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			//do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</a>
	<?php //do_action( 'woocommerce_after_shop_loop_item' );cristian ?>
</li>-->
	<li class="product">    
         <div class="related-post-headline">
           <a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>" >
                        <?php //woocommerce_show_product_sale_flash( $post, $product ); 	                        
                        if (has_post_thumbnail( $loop->post->ID )){	                        			
                        	echo the_title()."</a></div>
							<div style='height:3px;background:".$_SESSION["color_eje"]."'></div>
                        	<div style='width:100%'>";                      		
                        	//echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                        	echo get_the_post_thumbnail($loop->post->ID, 'shop_single')."</div>"; 
                        }else{ 
                        	//echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="150px" height="150px" class="woocommerce-placeholder wp-post-image"/>'; 
                       		echo  the_title()."</div>";
                       		/*echo "<div style='font-size:0.8em;height:155px'>".apply_filters( 'woocommerce_short_description', $post->post_excerpt )."</div>"; cristian 16/01/15*/
                        }
                       ?> 	                                       	
                    <?php //woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>	
    </li>  